<?php

namespace App\Jobs;

use App\Mail\EmailVerificationOtpMail;
use App\Models\User;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEmailVerificationOtpMail
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public User $user,
        public string $otp,
        public string $purpose = 'email_verification'
    ) {
    }

    public function handle(): void
    {
        Mail::to($this->user->email)->send(
            new EmailVerificationOtpMail($this->user, $this->otp, $this->purpose)
        );
    }
}
