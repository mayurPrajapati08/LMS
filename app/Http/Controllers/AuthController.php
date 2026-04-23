<?php

namespace App\Http\Controllers;

use App\Jobs\SendEmailVerificationOtpMail;
use App\Models\EmailVerificationOtp;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\AbstractProvider as SocialiteProvider;

class AuthController extends Controller
{
    public function showLogin(): View
    {
        $this->captureSafeIntendedRedirect(request());

        return view('login_signup');
    }

    public function showRegister(): View
    {
        $this->captureSafeIntendedRedirect(request());

        return view('login_signup');
    }

    public function showForgotPasswordRequest(Request $request): View
    {
        $request->session()->forget('password_reset');

        return view('login_signup');
    }

    public function showForgotPasswordOtp(Request $request): RedirectResponse|View
    {
        if (! $request->session()->has('password_reset.user_id')) {
            return redirect()->route('password.request');
        }

        return view('login_signup');
    }

    public function showResetPasswordForm(Request $request): RedirectResponse|View
    {
        if (! $request->session()->get('password_reset.verified', false)) {
            return redirect()->route('password.request');
        }

        return view('login_signup');
    }

    public function showTwoFactorChallenge(Request $request): RedirectResponse|View
    {
        if (! $request->session()->has('two_factor_auth.user_id')) {
            return redirect()->to(route('login', absolute: false));
        }

        return view('auth.two_factor_challenge', [
            'email' => $request->session()->get('two_factor_auth.email'),
        ]);
    }

    public function redirectToGoogle(Request $request): RedirectResponse
    {
        if (RateLimiter::tooManyAttempts($this->socialThrottleKey($request), 5)) {
            return redirect()->to(route('login', absolute: false))->withErrors([
                'email' => 'Too many Google login attempts. Please wait a few minutes and try again.',
            ]);
        }

        RateLimiter::hit($this->socialThrottleKey($request), 300);

        /** @var SocialiteProvider $googleProvider */
        $googleProvider = Socialite::driver('google');

        return $googleProvider
            ->stateless()
            ->redirect();
    }

    public function handleGoogleCallback(Request $request): RedirectResponse
    {
        try {
            /** @var SocialiteProvider $googleProvider */
            $googleProvider = Socialite::driver('google');
            $googleUser = $googleProvider->stateless()->user();
        } catch (\Throwable $exception) {
            return redirect()->to(route('login', absolute: false))->withErrors([
                'email' => 'Google sign-in could not be completed. Please try again.',
            ]);
        }

        $email = $this->normalizeEmail((string) ($googleUser->getEmail() ?? ''));

        if ($email === '') {
            return redirect()->to(route('login', absolute: false))->withErrors([
                'email' => 'Your Google account did not return an email address.',
            ]);
        }

        $userRole = Role::firstOrCreate(['name' => 'user']);

        $user = User::query()
            ->where('google_id', $googleUser->getId())
            ->orWhere('email', $email)
            ->first();

        if (! $user) {
            $user = User::create([
                'name' => trim((string) ($googleUser->getName() ?: $googleUser->getNickname() ?: 'Google User')),
                'email' => $email,
                'google_id' => (string) $googleUser->getId(),
                'avatar_path' => $googleUser->getAvatar(),
                'password' => Str::password(32),
                'role_id' => $userRole->id,
                'email_verified_at' => now(),
            ]);
        } else {
            $user->google_id = $user->google_id ?: (string) $googleUser->getId();

            if (! $user->avatar_path && $googleUser->getAvatar()) {
                $user->avatar_path = $googleUser->getAvatar();
            }

            if (! $user->email_verified_at) {
                $user->email_verified_at = now();
            }

            $user->save();
        }

        RateLimiter::clear($this->socialThrottleKey($request));
        Auth::login($user, true);
        $request->session()->regenerate();

        if ($user->two_factor_enabled) {
            $this->sendOtpTo($user, 'login_two_factor');
            $request->session()->put('two_factor_auth.user_id', $user->id);
            $request->session()->put('two_factor_auth.remember', true);
            $request->session()->put('two_factor_auth.email', $user->email);
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            $request->session()->put('two_factor_auth.user_id', $user->id);
            $request->session()->put('two_factor_auth.remember', true);
            $request->session()->put('two_factor_auth.email', $user->email);

            return redirect()->to(route('two-factor.challenge', absolute: false))
                ->with('status', 'We sent a login verification code to your email address.');
        }

        $this->markUserAsLoggedIn($user);

        return redirect()->intended($this->redirectPathFor($user));
    }

    public function login(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ], [
            'email.required' => 'Enter your email address to sign in.',
            'email.email' => 'Enter a valid email address.',
            'password.required' => 'Enter your password to sign in.',
        ]);

        if (RateLimiter::tooManyAttempts($this->loginThrottleKey($request), 5)) {
            $seconds = RateLimiter::availableIn($this->loginThrottleKey($request));

            return back()
                ->withErrors([
                    'email' => 'Too many login attempts. Please try again in '.max(1, (int) ceil($seconds / 60)).' minute(s).',
                ])
                ->onlyInput('email');
        }

        $credentials = [
            'email' => $this->normalizeEmail($validated['email']),
            'password' => $validated['password'],
        ];
        $remember = $request->boolean('remember');

        if (! Auth::attempt($credentials, $remember)) {
            RateLimiter::hit($this->loginThrottleKey($request), 300);

            return back()
                ->withErrors([
                    'email' => 'The provided email or password is incorrect.',
                ])
                ->onlyInput('email');
        }

        RateLimiter::clear($this->loginThrottleKey($request));
        $request->session()->regenerate();
        /** @var User|null $user */
        $user = Auth::user();

        if (! $user?->hasVerifiedEmail()) {
            $this->sendOtpTo($user, 'email_verification');

            return redirect()->to(route('verification.notice', absolute: false))
                ->with('status', 'We sent a verification code to your email address.');
        }

        if ($user?->two_factor_enabled) {
            $this->sendOtpTo($user, 'login_two_factor');
            $request->session()->put('two_factor_auth.user_id', $user->id);
            $request->session()->put('two_factor_auth.remember', $remember);
            $request->session()->put('two_factor_auth.email', $user->email);
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            $request->session()->put('two_factor_auth.user_id', $user->id);
            $request->session()->put('two_factor_auth.remember', $remember);
            $request->session()->put('two_factor_auth.email', $user->email);

            return redirect()->to(route('two-factor.challenge', absolute: false))
                ->with('status', 'We sent a login verification code to your email address.');
        }

        $this->markUserAsLoggedIn($user);

        return redirect()->intended($this->redirectPathFor($user));
    }

    public function register(Request $request): RedirectResponse
    {
        if (RateLimiter::tooManyAttempts($this->registerThrottleKey($request), 5)) {
            $seconds = RateLimiter::availableIn($this->registerThrottleKey($request));

            return back()
                ->withErrors([
                    'email' => 'Too many signup attempts. Please try again in '.max(1, (int) ceil($seconds / 60)).' minute(s).',
                ])
                ->withInput($request->except('password', 'password_confirmation'));
        }

        RateLimiter::hit($this->registerThrottleKey($request), 300);

        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', $this->passwordRule()],
            'terms' => ['accepted'],
        ], [
            'first_name.required' => 'Enter your first name.',
            'last_name.required' => 'Enter your last name.',
            'email.required' => 'Enter your email address.',
            'email.email' => 'Enter a valid email address.',
            'email.unique' => 'This email is already registered. Try logging in instead.',
            'password.required' => 'Create a password for your account.',
            'password.confirmed' => 'Password and confirm password do not match.',
            'terms.accepted' => 'Please accept the terms to create your account.',
        ]);

        $userRole = Role::firstOrCreate(['name' => 'user']);

        $user = User::create([
            'name' => trim($validated['first_name'].' '.$validated['last_name']),
            'email' => $this->normalizeEmail($validated['email']),
            'password' => $validated['password'],
            'role_id' => $userRole->id,
        ]);

        RateLimiter::clear($this->registerThrottleKey($request));
        Auth::login($user);
        $request->session()->regenerate();
        $this->sendOtpTo($user, 'email_verification');

        return redirect()->to(route('verification.notice', absolute: false))
            ->with('status', 'Your account has been created. Enter the code sent to your email to verify it.');
    }

    public function sendPasswordResetOtp(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email', 'max:255'],
        ], [
            'email.required' => 'Enter your email address to reset your password.',
            'email.email' => 'Enter a valid email address.',
        ]);

        $email = $this->normalizeEmail($validated['email']);
        $user = User::query()->where('email', $email)->first();

        if (! $user) {
            return back()
                ->withErrors([
                    'email' => 'We could not find an account with that email address.',
                ])
                ->onlyInput('email');
        }

        if ($lockMessage = $this->otpLockMessage($user->id, 'password_reset')) {
            return back()
                ->withErrors([
                    'email' => $lockMessage,
                ])
                ->onlyInput('email');
        }

        $request->session()->put('password_reset.user_id', $user->id);
        $request->session()->put('password_reset.email', $user->email);
        $request->session()->put('password_reset.verified', false);

        $this->sendOtpTo($user, 'password_reset');

        return redirect()->route('password.otp.notice')
            ->with('status', 'We sent a password reset OTP to your email address.');
    }

    public function verifyPasswordResetOtp(Request $request): RedirectResponse
    {
        $request->validate([
            'otp' => ['required', 'digits:6'],
        ], [
            'otp.required' => 'Enter the 6-digit OTP sent to your email.',
            'otp.digits' => 'The verification code must be exactly 6 digits.',
        ]);

        $userId = (int) $request->session()->get('password_reset.user_id');

        if ($userId <= 0) {
            return redirect()->route('password.request');
        }

        if ($lockMessage = $this->otpLockMessage($userId, 'password_reset')) {
            return back()->withErrors([
                'otp' => $lockMessage,
            ]);
        }

        $otpRecord = $this->findValidOtp($userId, $request->string('otp')->toString(), 'password_reset');

        if (! $otpRecord) {
            $lockMessage = $this->registerFailedOtpAttempt($userId, 'password_reset');

            return back()->withErrors([
                'otp' => $lockMessage ?: 'The password reset OTP is invalid or expired.',
            ]);
        }

        $this->clearOtpAttemptState($userId, 'password_reset');
        EmailVerificationOtp::where('user_id', $userId)->where('purpose', 'password_reset')->delete();
        $request->session()->put('password_reset.verified', true);

        return redirect()->route('password.reset.form')
            ->with('status', 'OTP verified. You can now set a new password.');
    }

    public function resendPasswordResetOtp(Request $request): RedirectResponse
    {
        $userId = (int) $request->session()->get('password_reset.user_id');

        if ($userId <= 0) {
            return redirect()->route('password.request');
        }

        if ($lockMessage = $this->otpLockMessage($userId, 'password_reset')) {
            return back()->withErrors([
                'otp' => $lockMessage,
            ]);
        }

        $user = User::findOrFail($userId);
        $request->session()->put('password_reset.email', $user->email);
        $request->session()->put('password_reset.verified', false);
        $this->sendOtpTo($user, 'password_reset');

        return back()->with('status', 'A new password reset OTP has been sent to your email.');
    }

    public function resetPassword(Request $request): RedirectResponse
    {
        $userId = (int) $request->session()->get('password_reset.user_id');
        $verified = (bool) $request->session()->get('password_reset.verified', false);

        if ($userId <= 0 || ! $verified) {
            return redirect()->route('password.request');
        }

        $validated = $request->validate([
            'password' => ['required', 'confirmed', $this->passwordRule()],
        ], [
            'password.required' => 'Enter your new password.',
            'password.confirmed' => 'Password and confirm password do not match.',
        ]);

        $user = User::find($userId);

        if (! $user) {
            $request->session()->forget('password_reset');

            return redirect()->route('password.request')->withErrors([
                'email' => 'We could not find that account anymore. Please try again.',
            ]);
        }

        $user->forceFill([
            'password' => $validated['password'],
            'remember_token' => Str::random(60),
        ])->save();

        $this->clearOtpAttemptState($user->id, 'password_reset');
        EmailVerificationOtp::where('user_id', $user->id)->where('purpose', 'password_reset')->delete();
        $request->session()->forget('password_reset');

        return redirect()->route('login')->with('status', 'Your password has been reset successfully. You can sign in now.');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('status', 'You have been logged out successfully.');
    }

    public function showVerificationNotice(Request $request): RedirectResponse|View
    {
        /** @var User|null $user */
        $user = $request->user();

        if (! $user) {
            return redirect()->to(route('login', absolute: false));
        }

        if ($user->hasVerifiedEmail()) {
            return redirect($this->redirectPathFor($user));
        }

        return view('login_signup');
    }

    public function verifyOtp(Request $request): RedirectResponse
    {
        $request->validate([
            'otp' => ['required', 'digits:6'],
        ], [
            'otp.required' => 'Enter the 6-digit verification code.',
            'otp.digits' => 'The verification code must be exactly 6 digits.',
        ]);

        /** @var User|null $user */
        $user = $request->user();

        if (! $user) {
            return redirect()->to(route('login', absolute: false));
        }

        if ($user->hasVerifiedEmail()) {
            return redirect($this->redirectPathFor($user));
        }

        if ($lockMessage = $this->otpLockMessage($user->id, 'email_verification')) {
            return back()->withErrors([
                'otp' => $lockMessage,
            ]);
        }

        $otpRecord = $this->findValidOtp($user->id, $request->string('otp')->toString(), 'email_verification');

        if (! $otpRecord) {
            $lockMessage = $this->registerFailedOtpAttempt($user->id, 'email_verification');

            return back()->withErrors([
                'otp' => $lockMessage ?: 'The verification code is invalid or expired.',
            ]);
        }

        $this->clearOtpAttemptState($user->id, 'email_verification');
        $user->markEmailAsVerified();
        EmailVerificationOtp::where('user_id', $user->id)->where('purpose', 'email_verification')->delete();

        return redirect($this->redirectPathFor($user))
            ->with('status', 'Your email has been verified successfully.');
    }

    public function verifyTwoFactorOtp(Request $request): RedirectResponse
    {
        $request->validate([
            'otp' => ['required', 'digits:6'],
        ], [
            'otp.required' => 'Enter the 6-digit verification code.',
            'otp.digits' => 'The verification code must be exactly 6 digits.',
        ]);

        $userId = (int) $request->session()->get('two_factor_auth.user_id');

        if ($userId <= 0) {
            return redirect()->to(route('login', absolute: false));
        }

        if ($lockMessage = $this->otpLockMessage($userId, 'login_two_factor')) {
            return back()->withErrors([
                'otp' => $lockMessage,
            ]);
        }

        $otpRecord = $this->findValidOtp($userId, $request->string('otp')->toString(), 'login_two_factor');

        if (! $otpRecord) {
            $lockMessage = $this->registerFailedOtpAttempt($userId, 'login_two_factor');

            return back()->withErrors([
                'otp' => $lockMessage ?: 'The verification code is invalid or expired.',
            ]);
        }

        $remember = (bool) $request->session()->get('two_factor_auth.remember', false);
        $this->clearOtpAttemptState($userId, 'login_two_factor');
        EmailVerificationOtp::where('user_id', $userId)->where('purpose', 'login_two_factor')->delete();
        Auth::loginUsingId($userId, $remember);
        $request->session()->forget('two_factor_auth');
        $request->session()->regenerate();

        /** @var User|null $authenticatedUser */
        $authenticatedUser = Auth::user();

        if ($authenticatedUser) {
            $this->markUserAsLoggedIn($authenticatedUser);
        }

        return redirect()->intended($this->redirectPathFor($authenticatedUser));
    }

    public function resendOtp(Request $request): RedirectResponse
    {
        /** @var User|null $user */
        $user = $request->user();

        if (! $user) {
            return redirect()->to(route('login', absolute: false));
        }

        if ($user->hasVerifiedEmail()) {
            return redirect($this->redirectPathFor($user));
        }

        if ($lockMessage = $this->otpLockMessage($user->id, 'email_verification')) {
            return back()->withErrors([
                'otp' => $lockMessage,
            ]);
        }

        $this->sendOtpTo($user, 'email_verification');

        return back()->with('status', 'A new verification code has been sent to your email.');
    }

    public function resendTwoFactorOtp(Request $request): RedirectResponse
    {
        $userId = (int) $request->session()->get('two_factor_auth.user_id');

        if ($userId <= 0) {
            return redirect()->to(route('login', absolute: false));
        }

        if ($lockMessage = $this->otpLockMessage($userId, 'login_two_factor')) {
            return back()->withErrors([
                'otp' => $lockMessage,
            ]);
        }

        $user = User::findOrFail($userId);
        $this->sendOtpTo($user, 'login_two_factor');

        return back()->with('status', 'A new login verification code has been sent to your email.');
    }

    protected function redirectPathFor(?User $user): string
    {
        $roleName = strtolower($user?->role?->name ?? '');

        return match ($roleName) {
            'super admin', 'admin' => '/admin/dashboard',
            'hr team' => '/hr/dashboard',
            'instructor' => '/instructor/dashboard',
            default => '/student/dashboard',
        };
    }

    protected function sendOtpTo(User $user, string $purpose = 'email_verification'): void
    {
        EmailVerificationOtp::where('user_id', $user->id)
            ->where('purpose', $purpose)
            ->delete();

        $otp = (string) random_int(100000, 999999);

        EmailVerificationOtp::create([
            'user_id' => $user->id,
            'purpose' => $purpose,
            'otp' => Hash::make($otp),
            'expires_at' => now()->addMinutes(10),
        ]);

        SendEmailVerificationOtpMail::dispatchAfterResponse($user, $otp, $purpose);
    }

    protected function findValidOtp(int $userId, string $otp, string $purpose): ?EmailVerificationOtp
    {
        $otpRecord = EmailVerificationOtp::query()
            ->where('user_id', $userId)
            ->where('purpose', $purpose)
            ->latest()
            ->first();

        if (! $otpRecord) {
            return null;
        }

        if ($otpRecord->expires_at->isPast()) {
            $otpRecord->delete();

            return null;
        }

        $storedOtp = (string) $otpRecord->otp;
        $otpMatches = str_starts_with($storedOtp, '$2y$')
            ? Hash::check($otp, $storedOtp)
            : hash_equals($storedOtp, $otp);

        if (! $otpMatches) {
            return null;
        }

        return $otpRecord;
    }

    protected function otpLockMessage(int $userId, string $purpose): ?string
    {
        $lockUntil = Cache::get($this->otpLockKey($userId, $purpose));

        if (! $lockUntil) {
            return null;
        }

        $lockUntilTime = \Illuminate\Support\Carbon::parse($lockUntil);

        if ($lockUntilTime->isPast()) {
            $this->clearOtpAttemptState($userId, $purpose);

            return null;
        }

        return 'Too many incorrect OTP attempts. Please wait 5 minutes before trying again.';
    }

    protected function registerFailedOtpAttempt(int $userId, string $purpose): ?string
    {
        $attemptsKey = $this->otpAttemptsKey($userId, $purpose);
        $attempts = (int) Cache::get($attemptsKey, 0) + 1;

        if ($attempts >= 3) {
            Cache::put($this->otpLockKey($userId, $purpose), now()->addMinutes(5)->toDateTimeString(), now()->addMinutes(5));
            Cache::forget($attemptsKey);

            return 'Too many incorrect OTP attempts. Please wait 5 minutes before trying again.';
        }

        Cache::put($attemptsKey, $attempts, now()->addMinutes(10));

        return null;
    }

    protected function clearOtpAttemptState(int $userId, string $purpose): void
    {
        Cache::forget($this->otpAttemptsKey($userId, $purpose));
        Cache::forget($this->otpLockKey($userId, $purpose));
    }

    protected function otpAttemptsKey(int $userId, string $purpose): string
    {
        return 'otp_attempts:'.$purpose.':'.$userId;
    }

    protected function otpLockKey(int $userId, string $purpose): string
    {
        return 'otp_lock:'.$purpose.':'.$userId;
    }

    protected function loginThrottleKey(Request $request): string
    {
        return Str::lower(trim((string) $request->input('email'))).'|'.$request->ip();
    }

    protected function registerThrottleKey(Request $request): string
    {
        return 'register|'.$request->ip();
    }

    protected function socialThrottleKey(Request $request): string
    {
        return 'social|google|'.$request->ip();
    }

    protected function passwordRule(): Password
    {
        return Password::min(8)
            ->mixedCase()
            ->numbers()
            ->symbols();
    }

    protected function normalizeEmail(string $email): string
    {
        return Str::lower(trim($email));
    }

    protected function markUserAsLoggedIn(User $user): void
    {
        $user->forceFill([
            'last_login_at' => now(),
        ])->save();
    }

    protected function captureSafeIntendedRedirect(Request $request): void
    {
        $redirectTo = $this->sanitizeInternalRedirect((string) $request->query('redirect_to', ''));

        if ($redirectTo !== null) {
            $request->session()->put('url.intended', $redirectTo);
        }
    }

    protected function sanitizeInternalRedirect(string $redirectTo): ?string
    {
        $redirectTo = trim($redirectTo);

        if ($redirectTo === '') {
            return null;
        }

        if (str_contains($redirectTo, '\\')) {
            return null;
        }

        if (! str_starts_with($redirectTo, '/')) {
            return null;
        }

        if (str_starts_with($redirectTo, '//')) {
            return null;
        }

        $parts = parse_url($redirectTo);

        if ($parts === false || isset($parts['scheme']) || isset($parts['host'])) {
            return null;
        }

        return $redirectTo;
    }

}
