<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;

class TicketsPurchased extends Mailable
{
    use Queueable, SerializesModels;

    public array $ticketQrUrls = [];

    public function __construct(public Order $order)
    {
        foreach ($order->tickets as $ticket) {
            $signedUrl = URL::temporarySignedRoute(
                'tickets.signed',
                now()->addDays(30),
                ['ticket' => $ticket->code]
            );

            // QuickChart QR API — free, no key needed, returns a PNG image
            $this->ticketQrUrls[$ticket->code] =
                'https://quickchart.io/qr?text=' . urlencode($signedUrl) .
                '&size=200&margin=2&dark=000000&light=ffffff';
        }
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '🎫 Tvoje lístky — ' . $this->order->event->title,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.tickets_purchased',
        );
    }
}