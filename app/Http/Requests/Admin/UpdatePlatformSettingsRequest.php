<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePlatformSettingsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return (bool) $this->user()?->hasAnyRole(['admin', 'super admin']);
    }

    public function rules(): array
    {
        $section = (string) $this->input('section');

        $rules = match ($section) {
            'institution' => [
                'institution_name' => ['required', 'string', 'max:255'],
                'institution_email' => ['required', 'email', 'max:255'],
                'institution_phone' => ['nullable', 'string', 'max:50'],
                'institution_address' => ['nullable', 'string', 'max:255'],
                'institution_timezone' => ['required', 'string', 'max:100'],
                'institution_tagline' => ['nullable', 'string', 'max:255'],
            ],
            'payments' => [
                'payment_currency' => ['required', 'string', 'max:10'],
                'payment_tax_rate' => ['nullable', 'numeric', 'min:0', 'max:100'],
                'payment_stripe_enabled' => ['nullable', 'boolean'],
                'payment_razorpay_enabled' => ['nullable', 'boolean'],
                'payment_manual_enabled' => ['nullable', 'boolean'],
            ],
            'catalog' => [
                'catalog_default_mode' => ['required', 'in:offline,online'],
                'catalog_online_enabled' => ['nullable', 'boolean'],
                'catalog_offline_enabled' => ['nullable', 'boolean'],
                'online_student_access_mode' => ['required', 'in:disabled,limited'],
                'student_catalog_enabled' => ['nullable', 'boolean'],
                'student_wishlist_enabled' => ['nullable', 'boolean'],
                'student_cart_enabled' => ['nullable', 'boolean'],
                'student_checkout_enabled' => ['nullable', 'boolean'],
                'student_payments_enabled' => ['nullable', 'boolean'],
                'public_lead_gate_enabled' => ['nullable', 'boolean'],
                'workshop_lead_gate_enabled' => ['nullable', 'boolean'],
            ],
            'notifications' => [
                'email_from_name' => ['required', 'string', 'max:255'],
                'email_from_address' => ['required', 'email', 'max:255'],
                'email_support_address' => ['required', 'email', 'max:255'],
                'exception_alert_email' => ['required', 'email', 'max:255'],
                'notification_new_enrollment' => ['nullable', 'boolean'],
                'notification_new_review' => ['nullable', 'boolean'],
                'notification_support_alerts' => ['nullable', 'boolean'],
                'notification_daily_digest' => ['nullable', 'boolean'],
            ],
            'integrations' => [
                'integration_cloudinary_folder' => ['nullable', 'string', 'max:255'],
                'integration_razorpay_key' => ['nullable', 'string', 'max:255'],
                'integration_app_url' => ['nullable', 'string', 'max:255'],
                'integration_webhook_secret' => ['nullable', 'string', 'max:255'],
            ],
            default => [],
        };

        if ($rules !== []) {
            $rules['current_password'] = ['required', 'current_password'];
        }

        return $rules;
    }
}
