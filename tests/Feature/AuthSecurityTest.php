<?php

namespace Tests\Feature;

use App\Models\EmailVerificationOtp;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AuthSecurityTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function email_verification_accepts_hashed_otp_storage(): void
    {
        $role = Role::query()->create(['name' => 'user']);

        $user = User::query()->create([
            'name' => 'Student',
            'email' => 'student@example.com',
            'password' => 'Secret123!!',
            'role_id' => $role->id,
        ]);

        EmailVerificationOtp::query()->create([
            'user_id' => $user->id,
            'purpose' => 'email_verification',
            'otp' => Hash::make('123456'),
            'expires_at' => now()->addMinutes(10),
        ]);

        $response = $this->actingAs($user)->post(route('verification.verify'), [
            'otp' => '123456',
        ]);

        $response->assertRedirect('/student/dashboard');
        $this->assertNotNull($user->fresh()->email_verified_at);
    }

    #[Test]
    public function login_page_ignores_external_redirect_targets(): void
    {
        $this->get('/login?redirect_to=https://evil.example/phish')
            ->assertOk();

        $this->assertNull(session('url.intended'));
    }

    #[Test]
    public function login_page_accepts_internal_redirect_targets_only(): void
    {
        $this->get('/login?redirect_to=/career-paths/data-science-with-ai')
            ->assertOk();

        $this->assertSame('/career-paths/data-science-with-ai', session('url.intended'));
    }
}
