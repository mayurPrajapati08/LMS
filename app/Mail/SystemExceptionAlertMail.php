<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Http\Request;
use Throwable;

class SystemExceptionAlertMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Throwable $exception,
        public ?Request $request = null,
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Production Exception Alert: '.class_basename($this->exception),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.system_exception_alert',
            with: [
                'exception' => $this->exception,
                'requestData' => $this->request,
            ],
        );
    }
}
