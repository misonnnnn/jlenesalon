<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TestCustomerBookingConfirmationMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(public string $recipientEmail)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Test Booking Confirmation - Jlene Salon',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.test-customer-booking-confirmation',
            with: [
                'recipientEmail' => $this->recipientEmail,
            ],
        );
    }
}
