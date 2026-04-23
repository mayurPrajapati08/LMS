<?php

namespace Tests\Feature;

use App\Models\EmailVerificationOtp;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AuthFlowTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function password_can_be_reset_after_valid_otp_verification(): void
    {
        $role = Role::query()->create(['name' => 'user']);

        $user = User::query()->create([
            'name' => 'Student User',
            'email' => 'student@example.com',
            'password' => 'OldSecret123!!',
            'role_id' => $role->id,
            'email_verified_at' => now(),
        ]);

        EmailVerificationOtp::query()->create([
            'user_id' => $user->id,
            'purpose' => 'password_reset',
            'otp' => Hash::make('654321'),
            'expires_at' => now()->addMinutes(10),
        ]);

        $verifyResponse = $this
            ->withSession([
                'password_reset.user_id' => $user->id,
                'password_reset.email' => $user->email,
                'password_reset.verified' => false,
            ])
            ->post(route('password.otp.verify'), [
                'otp' => '654321',
            ]);

        $verifyResponse->assertRedirect(route('password.reset.form'));

        $resetResponse = $this
            ->withSession([
                'password_reset.user_id' => $user->id,
                'password_reset.email' => $user->email,
                'password_reset.verified' => true,
            ])
            ->post(route('password.update'), [
                'password' => 'NewSecret123!!',
                'password_confirmation' => 'NewSecret123!!',
            ]);

        $resetResponse->assertRedirect(route('login'));
        $this->assertTrue(Hash::check('NewSecret123!!', $user->fresh()->password));
    }

    #[Test]
    public function two_factor_login_completes_with_a_valid_hashed_otp(): void
    {
        $role = Role::query()->create(['name' => 'user']);

        $user = User::query()->create([
            'name' => 'Two Factor User',
            'email' => '2fa@example.com',
            'password' => 'Secret123!!',
            'role_id' => $role->id,
            'email_verified_at' => now(),
            'two_factor_enabled' => true,
        ]);

        EmailVerificationOtp::query()->create([
            'user_id' => $user->id,
            'purpose' => 'login_two_factor',
            'otp' => Hash::make('112233'),
            'expires_at' => now()->addMinutes(10),
        ]);

        $response = $this
            ->withSession([
                'two_factor_auth.user_id' => $user->id,
                'two_factor_auth.email' => $user->email,
                'two_factor_auth.remember' => true,
                'url.intended' => '/student/dashboard',
            ])
            ->post(route('two-factor.verify'), [
                'otp' => '112233',
            ]);

        $response->assertRedirect('/student/dashboard');
        $this->assertAuthenticatedAs($user);
    }
}
