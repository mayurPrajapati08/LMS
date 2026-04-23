<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EmailVerificationOtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public User $user,
        public string $otp,
        public string $purpose = 'email_verification'
    ) {
    }

    public function envelope(): Envelope
    {
        $subject = match ($this->purpose) {
            'login_two_factor' => 'Your CodeInYourself Login OTP',
            'password_reset' => 'Your CodeInYourself Password Reset OTP',
            default => 'Your CodeInYourself Signup OTP',
        };

        return new Envelope(
            from: new Address(config('mail.from.address'), 'No-Reply | CodeInYourself'),
            subject: $subject,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.verify_email_otp',
        );
    }
}
