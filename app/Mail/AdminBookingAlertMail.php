<?php

namespace App\Mail;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AdminBookingAlertMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Booking $booking)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Booking Received - #' . $this->booking->id,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.admin-booking-alert',
            with: [
                'booking' => $this->booking,
            ],
        );
    }
}
