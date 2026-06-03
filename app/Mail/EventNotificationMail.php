<?php

namespace App\Mail;

use App\Models\Event;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EventNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public Event $event;

    public function __construct(Event $event)
    {
        $this->event = $event;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->event->email_subject,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.event-notification',
            with: [
                'event' => $this->event,
            ]
        );
    }

    public function attachments(): array
    {
        return [];
    }
}