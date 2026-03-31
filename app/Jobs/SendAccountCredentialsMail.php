<?php

namespace App\Jobs;

use App\Mail\AccountCredentialsMail;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendAccountCredentialsMail
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public string $recipientName,
        public string $email,
        public string $password,
        public string $roleLabel,
        public string $loginUrl
    ) {
    }

    public function handle(): void
    {
        Mail::to($this->email)->send(
            new AccountCredentialsMail(
                $this->recipientName,
                $this->email,
                $this->password,
                $this->roleLabel,
                $this->loginUrl
            )
        );
    }
}
