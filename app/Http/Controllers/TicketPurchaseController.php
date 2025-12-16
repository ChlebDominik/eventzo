<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Order;
use App\Models\Ticket;
use App\Models\TicketType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TicketPurchaseController extends Controller
{
    public function buy(Request $request, Event $event)
    {
        $request->validate([
            'ticket_type_id' => 'required|exists:ticket_types,id',
            'quantity' => 'required|integer|min:1|max:10',
        ]);

        /** @var TicketType $type */
        $type = TicketType::query()
            ->where('event_id', $event->id)
            ->findOrFail($request->ticket_type_id);

        $qty = (int) $request->quantity;

        // jednoduchá dostupnosť: počet vydaných lístkov nesmie prekročiť quantity
        $sold = Ticket::whereHas('ticketType', fn($q) => $q->where('id', $type->id))->count();
        if ($sold + $qty > $type->quantity) {
            return back()->with('error', 'Nedostupný počet lístkov.');
        }

        $user = $request->user();

        $order = DB::transaction(function () use ($user, $event, $type, $qty) {
            $total = $type->price_cents * $qty;

            $order = Order::create([
                'user_id' => $user->id,
                'event_id' => $event->id,
                'status' => 'paid', // bez payment gateway
                'total_cents' => $total,
            ]);

            for ($i = 0; $i < $qty; $i++) {
                Ticket::create([
                    'order_id' => $order->id,
                    'ticket_type_id' => $type->id,
                    'code' => (string) Str::uuid(),
                ]);
            }

            return $order;
        });

        return redirect()->route('orders.show', $order)->with('success', 'Lístky boli vytvorené.');
    }
}
