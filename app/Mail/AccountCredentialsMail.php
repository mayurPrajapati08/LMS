<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AccountCredentialsMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $recipientName,
        public string $email,
        public string $password,
        public string $roleLabel,
        public string $loginUrl
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(config('mail.from.address'), 'CodeInYourself Accounts'),
            subject: "Your CodeInYourself {$this->roleLabel} account is ready",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.account_credentials',
        );
    }
}
