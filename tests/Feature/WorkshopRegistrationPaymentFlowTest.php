<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use App\Models\Workshop;
use App\Models\WorkshopRegistration;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WorkshopRegistrationPaymentFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_workshop_registration_creates_pending_seat_request_without_payment_fields(): void
    {
        $workshop = Workshop::query()->create([
            'title' => 'AI Workshop',
            'is_active' => true,
            'price' => 0,
            'currency' => 'INR',
            'payment_enabled' => false,
        ]);

        $response = $this->post(route('home.workshop.register'), [
            'workshop_id' => $workshop->id,
            'name' => 'Mayur Patel',
            'email' => 'mayur@example.com',
            'phone' => '+919999999999',
            'attendance_mode' => 'Online',
        ]);

        $response->assertRedirect(route('home.free_workshop'));

        $this->assertDatabaseHas('workshop_registrations', [
            'workshop_id' => $workshop->id,
            'email' => 'mayur@example.com',
            'payment_status' => 'not_required',
            'registration_status' => 'pending',
            'payment_reference' => null,
            'payment_screenshot_path' => null,
        ]);
    }

    public function test_public_paid_workshop_payment_verification_creates_confirmed_registration(): void
    {
        config()->set('services.razorpay.key_secret', 'test_secret');

        $workshop = Workshop::query()->create([
            'title' => 'Paid Workshop',
            'is_active' => true,
            'price' => 1499,
            'currency' => 'INR',
            'payment_enabled' => true,
        ]);

        $paymentId = 'pay_test_123';
        $orderId = 'order_test_123';
        $signature = hash_hmac('sha256', $orderId.'|'.$paymentId, 'test_secret');

        $response = $this->post(route('home.workshop.verify-payment'), [
            'workshop_id' => $workshop->id,
            'name' => 'Mayur Patel',
            'email' => 'mayur@example.com',
            'phone' => '+919999999999',
            'attendance_mode' => 'Online',
            'razorpay_payment_id' => $paymentId,
            'razorpay_order_id' => $orderId,
            'razorpay_signature' => $signature,
        ]);

        $response->assertRedirect(route('home.free_workshop'));

        $this->assertDatabaseHas('workshop_registrations', [
            'workshop_id' => $workshop->id,
            'email' => 'mayur@example.com',
            'payment_reference' => $paymentId,
            'payment_status' => 'verified',
            'registration_status' => 'confirmed',
        ]);
    }

    public function test_hr_can_verify_payment_and_confirm_registration(): void
    {
        $role = Role::query()->create(['name' => 'hr team']);
        $hrUser = User::factory()->create([
            'role_id' => $role->id,
            'email_verified_at' => now(),
        ]);

        $workshop = Workshop::query()->create([
            'title' => 'Laravel Sprint',
            'is_active' => true,
            'price' => 499,
            'currency' => 'INR',
            'payment_enabled' => true,
        ]);

        $registration = WorkshopRegistration::query()->create([
            'workshop_id' => $workshop->id,
            'name' => 'Test User',
            'email' => 'learner@example.com',
            'payment_amount' => 499,
            'currency' => 'INR',
            'payment_reference' => 'REF001',
            'payment_status' => 'pending',
            'registration_status' => 'pending',
        ]);

        $response = $this->actingAs($hrUser)->put(route('hr.workshop-registrations.update', $registration), [
            'payment_status' => 'verified',
            'registration_status' => 'pending',
            'hr_notes' => 'Payment verified successfully.',
        ]);

        $response->assertRedirect();

        $registration->refresh();

        $this->assertSame('verified', $registration->payment_status);
        $this->assertSame('confirmed', $registration->registration_status);
        $this->assertSame($hrUser->id, $registration->reviewed_by);
        $this->assertNotNull($registration->reviewed_at);
    }
}
