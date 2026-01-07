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
        // ticket môže vidieť len jeho majiteľ (cez order->user_id)
        $ticket->load('order.event', 'ticketType', 'checkin');
        abort_unless($ticket->order->user_id === $request->user()->id, 403);

        $signedUrl = URL::temporarySignedRoute(
            'tickets.signed',
            now()->addDays(7),
            ['ticket' => $ticket->code]
        );

        $qrSvg = QrCode::size(220)->generate($signedUrl);

        return view('tickets.show', compact('ticket', 'qrSvg', 'signedUrl'));
    }

    // toto sa používa v QR (podpísaný link)
    public function signed(Request $request, Ticket $ticket)
    {
        $ticket->load('order.event', 'ticketType', 'checkin');

        return view('tickets.signed', compact('ticket'));
    }
}
