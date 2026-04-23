<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SystemExceptionAlertMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public array $report,
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Production Exception Alert: '.($this->report['exception']['short_class'] ?? 'Application Error'),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.system_exception_alert',
            with: [
                'report' => $this->report,
            ],
        );
    }
}
