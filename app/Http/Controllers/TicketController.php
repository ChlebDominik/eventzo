<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class TicketController extends Controller
{
    public function show(Request $request, Ticket $ticket)
    {
        $ticket->load('order.event', 'ticketType', 'checkin');
        abort_unless($ticket->order->user_id === $request->user()->id, 403);

        $signedUrl = URL::temporarySignedRoute(
            'tickets.signed',
            now()->addDays(30),
            ['ticket' => $ticket->code]
        );

        $qrSvg = QrCode::format('svg')
            ->size(220)
            ->color(255, 255, 255)       // white modules
            ->backgroundColor(18, 18, 30) // dark background matching site
            ->generate($signedUrl);

        return view('tickets.show', compact('ticket', 'qrSvg', 'signedUrl'));
    }

    public function signed(Request $request, Ticket $ticket)
    {
        $ticket->load('order.event', 'ticketType', 'checkin');
        return view('tickets.signed', compact('ticket'));
    }
}