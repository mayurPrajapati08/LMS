<!DOCTYPE html>

<html class="light" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Login &amp; Signup | CodeInYourself</title>
    <link rel="stylesheet" href="{{ '/chatbot/chatbot.css?v=' . filemtime(public_path('chatbot/chatbot.css')) }}">
    <script src="{{ '/chatbot/chatbot.js?v=' . filemtime(public_path('chatbot/chatbot.js')) }}" defer></script>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700;800&amp;family=Manrope:wght@400;500;600;700;800&amp;family=Inter:wght@400;500;600&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "outline": "#717786",
                        "primary-fixed-dim": "#adc7ff",
                        "primary-fixed": "#d8e2ff",
                        "on-tertiary": "#ffffff",
                        "on-error-container": "#93000a",
                        "on-secondary": "#ffffff",
                        "outline-variant": "#c1c6d7",
                        "background": "#f7f9ff",
                        "secondary-fixed": "#dae2ff",
                        "surface-container-lowest": "#ffffff",
                        "tertiary-fixed-dim": "#66df75",
                        "on-primary-fixed-variant": "#004493",
                        "on-primary-container": "#fefcff",
                        "on-primary": "#ffffff",
                        "tertiary-fixed": "#83fc8e",
                        "inverse-surface": "#2d3135",
                        "inverse-primary": "#adc7ff",
                        "surface-container-highest": "#e0e3e8",
                        "on-tertiary-fixed": "#002106",
                        "primary-container": "#0070ea",
                        "surface-tint": "#6a3378",
                        "on-tertiary-fixed-variant": "#00531a",
                        "surface-dim": "#d7dadf",
                        "secondary-fixed-dim": "#bec6e3",
                        "on-secondary-container": "#5a627b",
                        "surface-bright": "#f7f9ff",
                        "secondary-container": "#d7dffd",
                        "tertiary": "#006b24",
                        "error": "#ba1a1a",
                        "on-secondary-fixed-variant": "#3e465e",
                        "on-background": "#181c20",
                        "primary": "#6a3378",
                        "on-surface": "#181c20",
                        "error-container": "#ffdad6",
                        "surface-container-low": "#f1f4f9",
                        "surface-container": "#ebeef3",
                        "tertiary-container": "#008730",
                        "on-error": "#ffffff",
                        "surface": "#f7f9ff",
                        "on-surface-variant": "#414754",
                        "on-tertiary-container": "#f7fff2",
                        "on-primary-fixed": "#001a41",
                        "secondary": "#565e77",
                        "surface-variant": "#e0e3e8",
                        "on-secondary-fixed": "#131b30",
                        "inverse-on-surface": "#eef1f6",
                        "surface-container-high": "#e5e8ee"
                    },
                    fontFamily: {
                        "headline": ["Manrope"],
                        "body": ["Inter"],
                        "label": ["Inter"]
                    },
                    borderRadius: {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                },
            },
        }
    </script>
    <style>
        html {
            scrollbar-gutter: stable;
            scrollbar-width: thin;
            scrollbar-color: rgba(106, 51, 120, 0.76) rgba(236, 240, 248, 0.96);
        }

        html::-webkit-scrollbar,
        body::-webkit-scrollbar {
            width: 12px;
        }

        html::-webkit-scrollbar-track,
        body::-webkit-scrollbar-track {
            background:
                linear-gradient(180deg, rgba(246, 249, 255, 0.98), rgba(228, 234, 245, 0.98));
            border-left: 1px solid rgba(205, 214, 231, 0.72);
        }

        html::-webkit-scrollbar-thumb,
        body::-webkit-scrollbar-thumb {
            background:
                linear-gradient(180deg, rgba(106, 51, 120, 0.90), rgba(0, 112, 234, 0.78));
            border: 2px solid rgba(246, 249, 255, 0.96);
            border-radius: 9999px;
            box-shadow:
                inset 0 1px 0 rgba(255,255,255,0.24),
                0 6px 16px rgba(59, 53, 109, 0.14);
        }

        html::-webkit-scrollbar-thumb:hover,
        body::-webkit-scrollbar-thumb:hover {
            background:
                linear-gradient(180deg, rgba(90, 41, 104, 0.94), rgba(0, 91, 192, 0.84));
        }

        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        .glass-card {
            background: linear-gradient(180deg, rgba(75, 35, 86, 0.74), rgba(106, 51, 120, 0.56));
            backdrop-filter: blur(14px);
            box-shadow: 0 18px 40px rgba(75, 35, 86, 0.24);
        }

        .auth-hero {
            background:
                radial-gradient(circle at top left, rgba(96, 165, 250, 0.20), transparent 34%),
                linear-gradient(160deg, #07152f 0%, #0a2558 55%, #081424 100%);
        }

        .auth-hero::before {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.04), transparent 36%);
            pointer-events: none;
        }

        .auth-hero::after {
            content: "";
            position: absolute;
            right: 3rem;
            top: 3rem;
            height: 12rem;
            width: 12rem;
            border-radius: 9999px;
            background: rgba(255, 255, 255, 0.06);
            filter: blur(40px);
            pointer-events: none;
        }

        .auth-logo-shell {
            position: relative;
            display: flex;
            width: min(100%, 21rem);
            justify-content: center;
            align-items: center;
            padding: 1rem 1.25rem;
            border-radius: 1.5rem;
            border: 1px solid rgba(255, 255, 255, 0.16);
            background: rgba(255, 255, 255, 0.96);
            box-shadow: 0 22px 55px rgba(8, 20, 36, 0.24);
        }

        .auth-logo-shell::after {
            content: "";
            position: absolute;
            inset: 8px;
            border-radius: 1.1rem;
            border: 1px solid rgba(103, 80, 164, 0.10);
            pointer-events: none;
        }

        .auth-point {
            display: flex;
            align-items: flex-start;
            gap: 0.875rem;
            padding: 0.95rem 1rem;
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 1rem;
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(10px);
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

    </style>
</head>

<body class="bg-surface font-body text-on-surface min-h-screen overflow-x-hidden selection:bg-primary-fixed selection:text-on-primary-fixed">
    @php
        $isSignup = request()->is('register');
        $isOtpVerification = request()->routeIs('verification.notice');
        $isForgotPasswordRequest = request()->routeIs('password.request');
        $isForgotPasswordOtp = request()->routeIs('password.otp.notice');
        $isForgotPasswordReset = request()->routeIs('password.reset.form');
        $isPasswordResetFlow = $isForgotPasswordRequest || $isForgotPasswordOtp || $isForgotPasswordReset;
        $passwordResetEmail = session('password_reset.email');

        $primaryError = $errors->first('email')
            ?: $errors->first('password')
            ?: $errors->first('otp')
            ?: $errors->first('first_name')
            ?: $errors->first('last_name')
            ?: $errors->first('terms');

        if ($isOtpVerification) {
            $pageTitle = 'Verify Your Email';
            $pageDescription = 'Enter the 6-digit code sent to '.auth()->user()->email.' to finish verification.';
            $submitText = 'Verify Email Address';
            $submitLoadingText = 'Verifying...';
            $errorTitle = 'Verification failed';
        } elseif ($isForgotPasswordRequest) {
            $pageTitle = 'Forgot Your Password?';
            $pageDescription = 'Enter your account email and we will send you a 6-digit OTP to reset your password.';
            $submitText = 'Send Password Reset OTP';
            $submitLoadingText = 'Sending OTP...';
            $errorTitle = 'Password reset could not be started';
        } elseif ($isForgotPasswordOtp) {
            $pageTitle = 'Verify Password Reset OTP';
            $pageDescription = 'Enter the 6-digit OTP sent to '.($passwordResetEmail ?: 'your email').' to continue.';
            $submitText = 'Verify OTP';
            $submitLoadingText = 'Verifying OTP...';
            $errorTitle = 'OTP verification failed';
        } elseif ($isForgotPasswordReset) {
            $pageTitle = 'Set a New Password';
            $pageDescription = 'Create a strong new password for '.($passwordResetEmail ?: 'your account').'.';
            $submitText = 'Update Password';
            $submitLoadingText = 'Updating password...';
            $errorTitle = 'Password could not be updated';
        } elseif ($isSignup) {
            $pageTitle = 'Create Your Account';
            $pageDescription = 'Start your learning journey with a new student account.';
            $submitText = 'Create Student Account';
            $submitLoadingText = 'Creating account and sending OTP...';
            $errorTitle = 'Signup could not be completed';
        } else {
            $pageTitle = 'Welcome Back';
            $pageDescription = 'Continue your learning journey today.';
            $submitText = 'Sign In to Account';
            $submitLoadingText = 'Signing in...';
            $errorTitle = 'Login could not be completed';
        }

        if ($isOtpVerification) {
            $formAction = route('verification.verify', absolute: false);
        } elseif ($isForgotPasswordRequest) {
            $formAction = route('password.email', absolute: false);
        } elseif ($isForgotPasswordOtp) {
            $formAction = route('password.otp.verify', absolute: false);
        } elseif ($isForgotPasswordReset) {
            $formAction = route('password.update', absolute: false);
        } elseif ($isSignup) {
            $formAction = route('register.store', absolute: false);
        } else {
            $formAction = route('login.attempt', absolute: false);
        }

        $brandLogo = asset('images/cyis logo 4.png');

        if ($isSignup) {
            $heroBadge = 'Student Signup';
            $heroTitle = 'Simply Signup And Start Exploring.';
            $heroDescription = 'Create your account with a cleaner layout and begin your learning journey without distractions.';
            $heroPoints = [
                'Use your email or Google account to get started quickly.',
                'Secure OTP verification keeps your account protected.',
                'Access lessons, workshops, and mentorship after signup.',
            ];
        } else {
            $heroBadge = 'Welcome Back';
            $heroTitle = 'Continue learning with focus.';
            $heroDescription = 'Return to your account and pick up where you left off with a clean, familiar workspace.';
            $heroPoints = [
                'Open your dashboard and resume your progress.',
                'Review lessons, projects, and recent activity in one place.',
                'Get back to workshops and support without extra steps.',
            ];
        }
    @endphp

    <x-shared.back-to-top />

    <main class="flex min-h-screen flex-col lg:flex-row">
        <section class="auth-hero relative hidden overflow-hidden lg:flex lg:min-h-screen lg:w-[45%] lg:self-stretch">
            <div class="relative z-10 flex w-full flex-col justify-center px-12 py-12 xl:px-16 lg:sticky lg:top-0 lg:min-h-screen">
                <div class="max-w-xl">
                    <div class="inline-flex items-center gap-3 rounded-full border border-white/15 bg-white/10 px-4 py-2 text-[0.72rem] font-bold uppercase tracking-[0.26em] text-white/80 backdrop-blur-xl">
                        <span class="h-2.5 w-2.5 rounded-full bg-emerald-300 shadow-[0_0_14px_rgba(110,231,183,0.9)]"></span>
                        {{ $heroBadge }}
                    </div>

                    <div class="auth-logo-shell mt-6">
                        <img src="{{ $brandLogo }}" alt="CodeInYourself logo" class="mx-auto block h-auto w-full max-w-[16.5rem] object-contain" loading="lazy" decoding="async" referrerpolicy="no-referrer" />
                    </div>

                    <h1 class="mt-8 font-headline text-4xl font-extrabold leading-tight text-white xl:text-5xl">
                        {{ $heroTitle }}
                    </h1>
                    <p class="mt-4 max-w-lg text-base leading-7 text-slate-200/90 xl:text-lg">
                        {{ $heroDescription }}
                    </p>

                    <div class="mt-8 space-y-3">
                        @foreach ($heroPoints as $point)
                            <div class="auth-point">
                                <span class="material-symbols-outlined text-[1.15rem] text-emerald-200">check_circle</span>
                                <p class="text-sm leading-6 text-slate-100 xl:text-base">
                                    {{ $point }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>

        <section class="flex w-full flex-col items-center bg-surface px-4 py-8 sm:px-6 md:px-10 md:py-10 lg:min-h-screen lg:w-[55%] lg:justify-center lg:px-12 lg:py-12 xl:px-16 xl:py-14">
            <div class="w-full max-w-md lg:max-w-[28rem]">
                <div class="mb-6 lg:hidden">
                    <div class="mx-auto flex max-w-xs justify-center rounded-[1.5rem] border border-outline-variant/40 bg-white px-5 py-4 shadow-[0_18px_40px_rgba(50,70,120,0.12)]">
                        <img src="{{ $brandLogo }}" alt="CodeInYourself logo" class="mx-auto block h-auto w-full max-w-[14rem] object-contain" loading="lazy" decoding="async" referrerpolicy="no-referrer" />
                    </div>
                </div>

                <header class="mb-6">
                    <h2 class="mb-2 text-3xl font-headline font-extrabold text-on-surface">
                        {{ $pageTitle }}
                    </h2>
                    <p class="font-medium text-on-surface-variant">
                        {{ $pageDescription }}
                    </p>
                </header>

                @unless ($isOtpVerification || $isPasswordResetFlow)
                    <div class="mb-6 flex rounded-xl bg-surface-container-low p-1.5">
                        <a href="{{ route('login', absolute: false) }}"
                            class="flex-1 rounded-lg py-2.5 text-center text-sm font-semibold transition-all {{ $isSignup ? 'text-on-surface-variant hover:text-on-surface' : 'bg-surface-container-lowest text-primary shadow-sm' }}">
                            Login
                        </a>
                        <a href="{{ route('register', absolute: false) }}"
                            class="flex-1 rounded-lg py-2.5 text-center text-sm font-semibold transition-all {{ $isSignup ? 'bg-surface-container-lowest text-primary shadow-sm' : 'text-on-surface-variant hover:text-on-surface' }}">
                            Signup
                        </a>
                    </div>

                    <div class="mb-6 space-y-3">
                        <a href="{{ route('login.google.redirect', absolute: false) }}" class="w-full flex items-center justify-center gap-3 bg-surface-container-lowest border border-outline-variant py-3 px-4 rounded-xl font-semibold text-on-surface hover:bg-surface-container transition-colors active:scale-[0.98] duration-200">
                            <svg class="w-5 h-5" viewbox="0 0 24 24">
                                <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"></path>
                                <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"></path>
                                <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"></path>
                                <path d="M12 5.38c1.62 0 3.06.56 4.21 1.66l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"></path>
                            </svg>
                            <span>{{ $isSignup ? 'Sign up with Google' : 'Continue with Google' }}</span>
                        </a>
                    </div>

                    <div class="relative mb-6">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-outline-variant/30"></div>
                        </div>
                        <div class="relative flex justify-center text-xs uppercase tracking-widest font-label font-semibold">
                            <span class="bg-surface px-4 text-on-surface-variant">{{ $isSignup ? 'Or sign up with email' : 'Or login with email' }}</span>
                        </div>
                    </div>
                @endunless

                @if (session('status'))
                    <div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700">
                        {{ session('status') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                        <p class="font-semibold">
                            {{ $errorTitle }}
                        </p>
                        @if ($primaryError)
                            <p class="mt-1">{{ $primaryError }}</p>
                        @endif
                    </div>
                @endif

                <form action="{{ $formAction }}" method="POST" class="space-y-5 lg:space-y-4">
                    @csrf
                    @if ($isOtpVerification || $isForgotPasswordOtp)
                        <div class="space-y-2 rounded-2xl border border-outline-variant/30 bg-surface-container-low px-5 py-4">
                            <p class="text-sm font-semibold text-on-surface">{{ $isOtpVerification ? 'Email Verification Code' : 'Password Reset Code' }}</p>
                            <p class="text-sm text-on-surface-variant">
                                {{ $isOtpVerification ? 'Check your inbox and enter the 6-digit OTP below.' : 'Check your inbox and enter the 6-digit OTP we sent for password reset.' }}
                            </p>
                        </div>

                        <div class="space-y-1.5">
                            <label class="block text-sm font-semibold text-on-surface-variant ml-1" for="otp">6-Digit OTP</label>
                            <input class="w-full bg-surface-container-lowest border rounded-xl px-4 py-4 text-center text-xl sm:text-2xl font-extrabold tracking-[0.25em] sm:tracking-[0.35em] text-on-surface focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all placeholder:text-outline {{ $errors->has('otp') ? 'border-red-400' : 'border-outline-variant/50' }}" id="otp" name="otp" placeholder="000000" type="text" inputmode="numeric" maxlength="6" autocomplete="one-time-code" value="{{ old('otp') }}" />
                            @error('otp')
                                <p class="ml-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    @elseif ($isForgotPasswordReset)
                        <div class="space-y-1.5">
                            <label class="block text-sm font-semibold text-on-surface-variant" for="password">New Password</label>
                            <div class="relative">
                                <input class="w-full bg-surface-container-lowest border rounded-xl px-4 py-3 text-on-surface focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all placeholder:text-outline {{ $errors->has('password') ? 'border-red-400' : 'border-outline-variant/50' }}" id="password" name="password" placeholder="........" type="password" autocomplete="new-password" />
                                <button class="absolute right-4 top-1/2 -translate-y-1/2 text-outline hover:text-on-surface transition-colors" type="button" data-password-toggle="password" aria-label="Show password">
                                    <span class="material-symbols-outlined text-sm" data-password-toggle-icon="password">visibility</span>
                                </button>
                            </div>
                            <div id="passwordStrengthPanel" class="hidden rounded-xl border border-outline-variant/30 bg-surface-container-low px-3 py-3">
                                <div class="flex items-center gap-3">
                                    <p class="shrink-0 text-xs font-semibold uppercase tracking-wide text-on-surface-variant">Strength</p>
                                    <div class="grid flex-1 grid-cols-4 gap-1.5">
                                        <span class="h-1.5 rounded-full bg-surface-variant" data-strength-bar></span>
                                        <span class="h-1.5 rounded-full bg-surface-variant" data-strength-bar></span>
                                        <span class="h-1.5 rounded-full bg-surface-variant" data-strength-bar></span>
                                        <span class="h-1.5 rounded-full bg-surface-variant" data-strength-bar></span>
                                    </div>
                                    <span id="passwordStrengthLabel" class="shrink-0 text-xs font-bold uppercase tracking-wide text-on-surface-variant">Too weak</span>
                                </div>
                                <div class="mt-2 flex flex-wrap gap-x-3 gap-y-1 text-xs">
                                    <span class="inline-flex items-center gap-1 text-on-surface-variant" data-password-rule="length">
                                        <span class="material-symbols-outlined text-sm">radio_button_unchecked</span>
                                        8+ chars
                                    </span>
                                    <span class="inline-flex items-center gap-1 text-on-surface-variant" data-password-rule="lower">
                                        <span class="material-symbols-outlined text-sm">radio_button_unchecked</span>
                                        lowercase
                                    </span>
                                    <span class="inline-flex items-center gap-1 text-on-surface-variant" data-password-rule="upper">
                                        <span class="material-symbols-outlined text-sm">radio_button_unchecked</span>
                                        uppercase
                                    </span>
                                    <span class="inline-flex items-center gap-1 text-on-surface-variant" data-password-rule="number">
                                        <span class="material-symbols-outlined text-sm">radio_button_unchecked</span>
                                        number
                                    </span>
                                    <span class="inline-flex items-center gap-1 text-on-surface-variant" data-password-rule="symbol">
                                        <span class="material-symbols-outlined text-sm">radio_button_unchecked</span>
                                        symbol
                                    </span>
                                </div>
                            </div>
                            @error('password')
                                <p class="ml-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-1.5">
                            <label class="block text-sm font-semibold text-on-surface-variant ml-1" for="confirm_password">Confirm New Password</label>
                            <div class="relative">
                                <input class="w-full bg-surface-container-lowest border rounded-xl px-4 py-3 text-on-surface focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all placeholder:text-outline {{ $errors->has('password') ? 'border-red-400' : 'border-outline-variant/50' }}" id="confirm_password" name="password_confirmation" placeholder="........" type="password" autocomplete="new-password" />
                                <button class="absolute right-4 top-1/2 -translate-y-1/2 text-outline hover:text-on-surface transition-colors" type="button" data-password-toggle="confirm_password" aria-label="Show confirm password">
                                    <span class="material-symbols-outlined text-sm" data-password-toggle-icon="confirm_password">visibility</span>
                                </button>
                            </div>
                            @if ($errors->has('password'))
                                <p class="ml-1 text-sm text-red-600">Confirm your password exactly the same.</p>
                            @endif
                        </div>
                    @elseif ($isSignup)
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div class="space-y-1.5">
                                <label class="block text-sm font-semibold text-on-surface-variant ml-1" for="first_name">First Name</label>
                                <input class="w-full bg-surface-container-lowest border rounded-xl px-4 py-3 text-on-surface focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all placeholder:text-outline {{ $errors->has('first_name') ? 'border-red-400' : 'border-outline-variant/50' }}" id="first_name" name="first_name" placeholder="First Name" type="text" maxlength="255" autocomplete="given-name" value="{{ old('first_name') }}" />
                                @error('first_name')
                                    <p class="ml-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="space-y-1.5">
                                <label class="block text-sm font-semibold text-on-surface-variant ml-1" for="last_name">Last Name</label>
                                <input class="w-full bg-surface-container-lowest border rounded-xl px-4 py-3 text-on-surface focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all placeholder:text-outline {{ $errors->has('last_name') ? 'border-red-400' : 'border-outline-variant/50' }}" id="last_name" name="last_name" placeholder="Last Name" type="text" maxlength="255" autocomplete="family-name" value="{{ old('last_name') }}" />
                                @error('last_name')
                                    <p class="ml-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    @endif

                    @unless ($isOtpVerification || $isForgotPasswordOtp || $isForgotPasswordReset)
                        <div class="space-y-1.5">
                            <label class="block text-sm font-semibold text-on-surface-variant ml-1" for="email">
                                {{ $isSignup || $isForgotPasswordRequest ? 'Email Address' : 'Work Email' }}
                            </label>
                            <input class="w-full bg-surface-container-lowest border rounded-xl px-4 py-3 text-on-surface focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all placeholder:text-outline {{ $errors->has('email') ? 'border-red-400' : 'border-outline-variant/50' }}" id="email" name="email" placeholder="{{ $isSignup || $isForgotPasswordRequest ? 'you@example.com' : 'name@company.com' }}" type="email" maxlength="255" autocomplete="email" autocapitalize="off" spellcheck="false" value="{{ old('email', $isForgotPasswordRequest ? $passwordResetEmail : null) }}" />
                            @error('email')
                                <p class="ml-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        @unless ($isForgotPasswordRequest)
                            <div class="space-y-1.5">
                                <div class="flex justify-between items-center ml-1">
                                    <label class="block text-sm font-semibold text-on-surface-variant" for="password">Password</label>
                                    @unless ($isSignup)
                                        <a class="text-xs font-bold text-primary hover:underline underline-offset-4" href="{{ route('password.request', absolute: false) }}">Forgot Password?</a>
                                    @endunless
                                </div>
                                <div class="relative">
                                    <input class="w-full bg-surface-container-lowest border rounded-xl px-4 py-3 text-on-surface focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all placeholder:text-outline {{ $errors->has('password') ? 'border-red-400' : 'border-outline-variant/50' }}" id="password" name="password" placeholder="........" type="password" autocomplete="{{ $isSignup ? 'new-password' : 'current-password' }}" />
                                    <button class="absolute right-4 top-1/2 -translate-y-1/2 text-outline hover:text-on-surface transition-colors" type="button" data-password-toggle="password" aria-label="Show password">
                                        <span class="material-symbols-outlined text-sm" data-password-toggle-icon="password">visibility</span>
                                    </button>
                                </div>
                                @if ($isSignup)
                                    <div id="passwordStrengthPanel" class="hidden rounded-xl border border-outline-variant/30 bg-surface-container-low px-3 py-3">
                                        <div class="flex items-center gap-3">
                                            <p class="shrink-0 text-xs font-semibold uppercase tracking-wide text-on-surface-variant">Strength</p>
                                            <div class="grid flex-1 grid-cols-4 gap-1.5">
                                                <span class="h-1.5 rounded-full bg-surface-variant" data-strength-bar></span>
                                                <span class="h-1.5 rounded-full bg-surface-variant" data-strength-bar></span>
                                                <span class="h-1.5 rounded-full bg-surface-variant" data-strength-bar></span>
                                                <span class="h-1.5 rounded-full bg-surface-variant" data-strength-bar></span>
                                            </div>
                                            <span id="passwordStrengthLabel" class="shrink-0 text-xs font-bold uppercase tracking-wide text-on-surface-variant">Too weak</span>
                                        </div>
                                        <div class="mt-2 flex flex-wrap gap-x-3 gap-y-1 text-xs">
                                            <span class="inline-flex items-center gap-1 text-on-surface-variant" data-password-rule="length">
                                                <span class="material-symbols-outlined text-sm">radio_button_unchecked</span>
                                                8+ chars
                                            </span>
                                            <span class="inline-flex items-center gap-1 text-on-surface-variant" data-password-rule="lower">
                                                <span class="material-symbols-outlined text-sm">radio_button_unchecked</span>
                                                lowercase
                                            </span>
                                            <span class="inline-flex items-center gap-1 text-on-surface-variant" data-password-rule="upper">
                                                <span class="material-symbols-outlined text-sm">radio_button_unchecked</span>
                                                uppercase
                                            </span>
                                            <span class="inline-flex items-center gap-1 text-on-surface-variant" data-password-rule="number">
                                                <span class="material-symbols-outlined text-sm">radio_button_unchecked</span>
                                                number
                                            </span>
                                            <span class="inline-flex items-center gap-1 text-on-surface-variant" data-password-rule="symbol">
                                                <span class="material-symbols-outlined text-sm">radio_button_unchecked</span>
                                                symbol
                                            </span>
                                        </div>
                                    </div>
                                @endif
                                @error('password')
                                    <p class="ml-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        @endunless

                        @if ($isSignup)
                            <div class="space-y-1.5">
                                <label class="block text-sm font-semibold text-on-surface-variant ml-1" for="confirm_password">Confirm Password</label>
                                <div class="relative">
                                    <input class="w-full bg-surface-container-lowest border rounded-xl px-4 py-3 text-on-surface focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all placeholder:text-outline {{ $errors->has('password') ? 'border-red-400' : 'border-outline-variant/50' }}" id="confirm_password" name="password_confirmation" placeholder="........" type="password" autocomplete="new-password" />
                                    <button class="absolute right-4 top-1/2 -translate-y-1/2 text-outline hover:text-on-surface transition-colors" type="button" data-password-toggle="confirm_password" aria-label="Show confirm password">
                                        <span class="material-symbols-outlined text-sm" data-password-toggle-icon="confirm_password">visibility</span>
                                    </button>
                                </div>
                                @if ($errors->has('password'))
                                    <p class="ml-1 text-sm text-red-600">Confirm your password exactly the same.</p>
                                @endif
                            </div>
                        @endif

                        @unless ($isForgotPasswordRequest)
                            <div class="flex items-start gap-2 ml-1">
                                <input class="mt-1 w-4 h-4 rounded border-outline-variant text-primary focus:ring-primary bg-surface-container-lowest" id="{{ $isSignup ? 'terms' : 'remember' }}" name="{{ $isSignup ? 'terms' : 'remember' }}" type="checkbox" value="1" {{ old($isSignup ? 'terms' : 'remember') ? 'checked' : '' }} />
                                <label class="text-sm font-medium text-on-surface-variant" for="{{ $isSignup ? 'terms' : 'remember' }}">
                                    {{ $isSignup ? 'I agree to the Terms of Service, Privacy Policy, and student community guidelines.' : 'Keep me logged in' }}
                                </label>
                            </div>
                            @if ($isSignup)
                                @error('terms')
                                    <p class="ml-1 -mt-4 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            @endif
                        @endunless
                    @endunless

                    <button class="w-full bg-primary-container text-on-primary-container font-headline font-bold py-3.5 rounded-xl shadow-lg shadow-primary/20 hover:bg-primary transition-all active:scale-[0.98] duration-200 disabled:cursor-not-allowed disabled:opacity-70" type="submit" data-submit-button data-loading-text="{{ $submitLoadingText }}">
                        {{ $submitText }}
                    </button>
                </form>

                @if ($isOtpVerification)
                    <form action="{{ route('verification.resend', absolute: false) }}" method="POST" class="mt-4">
                        @csrf
                        <button class="w-full bg-surface-container-lowest border border-outline-variant/50 text-on-surface font-semibold py-3 rounded-xl hover:bg-surface-container transition-all disabled:cursor-not-allowed disabled:opacity-70" type="submit" data-submit-button data-loading-text="Sending new OTP...">
                            Resend OTP
                        </button>
                    </form>
                @elseif ($isForgotPasswordOtp)
                    <form action="{{ route('password.otp.resend', absolute: false) }}" method="POST" class="mt-4">
                        @csrf
                        <button class="w-full bg-surface-container-lowest border border-outline-variant/50 text-on-surface font-semibold py-3 rounded-xl hover:bg-surface-container transition-all disabled:cursor-not-allowed disabled:opacity-70" type="submit" data-submit-button data-loading-text="Sending new OTP...">
                            Resend Password Reset OTP
                        </button>
                    </form>
                @endif

                <footer class="mt-8 text-center lg:mt-6">
                    @if ($isOtpVerification)
                        <p class="text-sm text-on-surface-variant">Need a different account?</p>
                        <form action="{{ route('logout') }}" method="POST" class="mt-3">
                            @csrf
                            <button class="text-on-surface font-semibold hover:underline" type="submit">Logout</button>
                        </form>
                    @elseif ($isPasswordResetFlow)
                        <p class="text-sm text-on-surface-variant">
                            Remembered your password?
                            <a class="text-on-surface font-semibold hover:underline" href="{{ route('login', absolute: false) }}">Back to login</a>
                        </p>
                        @if ($isForgotPasswordOtp)
                            <p class="mt-3 text-sm text-on-surface-variant">
                                Need to use another email?
                                <a class="text-on-surface font-semibold hover:underline" href="{{ route('password.request', absolute: false) }}">Start again</a>
                            </p>
                        @endif
                    @else
                        <p class="text-sm text-on-surface-variant">
                        @if ($isSignup)
                            Already have an account?
                            <a class="text-on-surface font-semibold hover:underline" href="{{ route('login', absolute: false) }}">Sign in</a>
                        @else
                            By signing in, you agree to our
                            <a class="text-on-surface font-semibold hover:underline" href="#">Terms of Service</a>
                            and
                            <a class="text-on-surface font-semibold hover:underline" href="#">Privacy Policy</a>.
                        @endif
                        </p>
                    @endif
                </footer>
            </div>
        </section>
    </main>

  
<div
    id="cyi-chatbot-root"
    data-align="left"
    data-health-url="/api/chatbot/health"
    data-context-url="/api/chatbot/context"
    data-inquiry-url="/api/chatbot/inquiries"
    data-csrf-token="{{ csrf_token() }}"
    data-owner-avatar="/images/owner 1.0.jpeg"
    data-owner-name="CodeInYourself Guide"
></div>

    <script>
        (function () {
            document.querySelectorAll('[data-password-toggle]').forEach(function (button) {
                button.addEventListener('click', function () {
                    var targetId = button.getAttribute('data-password-toggle');
                    var input = document.getElementById(targetId);
                    var icon = document.querySelector('[data-password-toggle-icon="' + targetId + '"]');

                    if (!input) {
                        return;
                    }

                    var showing = input.type === 'text';
                    input.type = showing ? 'password' : 'text';

                    if (icon) {
                        icon.textContent = showing ? 'visibility' : 'visibility_off';
                    }

                    button.setAttribute('aria-label', showing ? 'Show password' : 'Hide password');
                });
            });

            var passwordInput = document.getElementById('password');
            var strengthPanel = document.getElementById('passwordStrengthPanel');
            var strengthLabel = document.getElementById('passwordStrengthLabel');
            var bars = document.querySelectorAll('[data-strength-bar]');
            var ruleItems = document.querySelectorAll('[data-password-rule]');

            if (!passwordInput || !strengthPanel || !strengthLabel || !bars.length || !ruleItems.length) {
                return;
            }

            var palette = {
                weak: { text: 'Too weak', color: 'rgb(220 38 38)', bar: 'rgb(248 113 113)' },
                fair: { text: 'Fair', color: 'rgb(217 119 6)', bar: 'rgb(251 191 36)' },
                good: { text: 'Good', color: 'rgb(37 99 235)', bar: 'rgb(96 165 250)' },
                strong: { text: 'Strong', color: 'rgb(22 163 74)', bar: 'rgb(74 222 128)' }
            };

            function setRuleState(rule, passed) {
                var icon = rule.querySelector('.material-symbols-outlined');
                rule.style.color = passed ? 'rgb(22 163 74)' : 'rgb(65 71 84)';
                if (icon) {
                    icon.textContent = passed ? 'check_circle' : 'radio_button_unchecked';
                }
            }

            function updateStrength() {
                var value = passwordInput.value || '';
                var checks = {
                    length: value.length >= 8,
                    lower: /[a-z]/.test(value),
                    upper: /[A-Z]/.test(value),
                    number: /\d/.test(value),
                    symbol: /[^A-Za-z0-9]/.test(value)
                };

                ruleItems.forEach(function (rule) {
                    var key = rule.getAttribute('data-password-rule');
                    setRuleState(rule, !!checks[key]);
                });

                var score = Object.values(checks).filter(Boolean).length;
                var level = score <= 2 ? 'weak' : score === 3 ? 'fair' : score === 4 ? 'good' : 'strong';

                if (!value.length) {
                    strengthPanel.classList.add('hidden');
                    level = 'weak';
                } else {
                    strengthPanel.classList.remove('hidden');
                }

                strengthLabel.textContent = palette[level].text;
                strengthLabel.style.color = palette[level].color;

                var activeBars = value.length ? Math.max(1, Math.min(4, Math.ceil(score * 0.8))) : 1;
                bars.forEach(function (bar, index) {
                    bar.style.backgroundColor = index < activeBars ? palette[level].bar : 'rgb(224 227 232)';
                });
            }

            passwordInput.addEventListener('input', updateStrength);
            updateStrength();

            document.querySelectorAll('form').forEach(function (form) {
                form.addEventListener('submit', function () {
                    var submitButton = form.querySelector('[data-submit-button]');

                    if (!submitButton || submitButton.disabled) {
                        return;
                    }

                    submitButton.disabled = true;

                    if (!submitButton.dataset.originalText) {
                        submitButton.dataset.originalText = submitButton.innerHTML.trim();
                    }

                    var loadingText = submitButton.getAttribute('data-loading-text');

                    if (loadingText) {
                        submitButton.textContent = loadingText;
                    }
                });
            });
        })();
    </script>
</body>

</html>
