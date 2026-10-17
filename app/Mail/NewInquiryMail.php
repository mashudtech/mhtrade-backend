<?php

namespace App\Mail;

use App\Models\Inquiry;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewInquiryMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Inquiry $inquiry) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "[{$this->inquiry->request_id}] New Trade Requirement — {$this->inquiry->vertical_label}",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.new-inquiry',
        );
    }
}
