<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckinController extends Controller
{
    public function index(Request $request, Event $event)
    {
        $this->authorize('update', $event);

        return view('checkin.index', compact('event'));
    }

    public function check(Request $request, Event $event)
    {
        $this->authorize('update', $event);

        $request->validate([
            'code' => 'required|string',
        ]);

        $ticket = Ticket::with('order.event', 'ticketType', 'checkin')
            ->where('code', trim($request->code))
            ->first();

        if (!$ticket) {
            return back()->with('error', 'Ticket neexistuje.');
        }

        if ($ticket->order->event_id !== $event->id) {
            return back()->with('error', 'Ticket nepatrí k tomuto eventu.');
        }

        if ($ticket->isUsed()) {
            return back()->with('error', 'Ticket už bol použitý.');
        }

        DB::transaction(function () use ($ticket, $request) {
            $ticket->update(['used_at' => now()]);
            $ticket->checkin()->create([
                'checked_in_by' => $request->user()->id,
                'checked_in_at' => now(),
            ]);
        });

        return back()->with('success', 'OK – vstup povolený. Ticket označený ako použitý.');
    }
}
