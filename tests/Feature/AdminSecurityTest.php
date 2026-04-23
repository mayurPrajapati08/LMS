<?php

namespace Tests\Feature;

use App\Jobs\SendAccountCredentialsMail;
use App\Models\AppSetting;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Bus;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AdminSecurityTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function super_admin_can_create_a_privileged_account_only_with_current_password_confirmation(): void
    {
        Bus::fake();

        $superAdminRole = Role::query()->create(['name' => 'super admin']);
        Role::query()->create(['name' => 'admin']);

        $superAdmin = User::query()->create([
            'name' => 'Root Admin',
            'email' => 'root@example.com',
            'password' => 'Secret123!!',
            'role_id' => $superAdminRole->id,
            'email_verified_at' => now(),
        ]);

        $response = $this->actingAs($superAdmin)->post(route('admin.admins.store'), [
            'name' => 'Ops Admin',
            'email' => 'ops@example.com',
            'role' => 'admin',
            'current_password' => 'Secret123!!',
        ]);

        $response->assertRedirect(route('admin.admins'));
        $this->assertDatabaseHas('users', [
            'email' => 'ops@example.com',
        ]);
        Bus::assertDispatched(SendAccountCredentialsMail::class);
    }

    #[Test]
    public function super_admin_cannot_delete_their_own_account(): void
    {
        $superAdminRole = Role::query()->create(['name' => 'super admin']);

        $superAdmin = User::query()->create([
            'name' => 'Root Admin',
            'email' => 'root@example.com',
            'password' => 'Secret123!!',
            'role_id' => $superAdminRole->id,
            'email_verified_at' => now(),
        ]);

        $response = $this->actingAs($superAdmin)->delete(route('admin.admins.destroy', $superAdmin), [
            'current_password' => 'Secret123!!',
        ]);

        $response->assertForbidden();
        $this->assertDatabaseHas('users', [
            'email' => 'root@example.com',
        ]);
    }

    #[Test]
    public function current_password_is_not_persisted_as_a_platform_setting(): void
    {
        $superAdminRole = Role::query()->create(['name' => 'super admin']);

        $superAdmin = User::query()->create([
            'name' => 'Root Admin',
            'email' => 'root@example.com',
            'password' => 'Secret123!!',
            'role_id' => $superAdminRole->id,
            'email_verified_at' => now(),
        ]);

        $response = $this->actingAs($superAdmin)->post(route('admin.settings.platform'), [
            'section' => 'integrations',
            'integration_app_url' => 'https://lms.example.com',
            'integration_razorpay_key' => 'rzp_key',
            'integration_webhook_secret' => 'hook-secret',
            'current_password' => 'Secret123!!',
        ]);

        $response->assertRedirect(route('admin.settings', ['tab' => 'integrations']));
        $this->assertDatabaseMissing('app_settings', [
            'key' => 'current_password',
        ]);
        $this->assertSame('hook-secret', AppSetting::query()->where('key', 'integration_webhook_secret')->value('value'));
    }
}
