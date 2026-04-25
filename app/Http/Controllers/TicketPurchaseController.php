<?php

namespace App\Http\Controllers;

use App\Mail\TicketsPurchased;
use App\Models\Event;
use App\Models\Order;
use App\Models\Ticket;
use App\Models\TicketType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class TicketPurchaseController extends Controller
{
    public function buy(Request $request, Event $event)
    {
        $request->validate([
            'ticket_type_id' => 'required|exists:ticket_types,id',
            'quantity'       => 'required|integer|min:1|max:10',
        ]);

        /** @var TicketType $type */
        $type = TicketType::query()
            ->where('event_id', $event->id)
            ->findOrFail($request->ticket_type_id);

        $qty = (int) $request->quantity;

        // Check available seats
        $sold = Ticket::whereHas('ticketType', fn($q) => $q->where('id', $type->id))->count();
        if ($sold + $qty > $type->quantity) {
            return back()->with('error', 'Nedostupný počet lístkov.');
        }

        $user  = $request->user();
        $total = $type->price_cents * $qty;

        // Check wallet balance before touching the DB
        if (! $user->canAfford($total)) {
            $missing = number_format(($total - $user->balance_cents) / 100, 2);
            return back()->with('error', "Nedostatok kreditu. Chýba ti {$missing} €. Dobij si peňaženku.");
        }

        // Declare $order outside try so it's in scope for the redirect
        $order = null;

        try {
            $order = DB::transaction(function () use ($user, $event, $type, $qty, $total) {
                $order = Order::create([
                    'user_id'     => $user->id,
                    'event_id'    => $event->id,
                    'status'      => 'paid',
                    'total_cents' => $total,
                ]);

                for ($i = 0; $i < $qty; $i++) {
                    Ticket::create([
                        'order_id'       => $order->id,
                        'ticket_type_id' => $type->id,
                        'code'           => (string) Str::uuid(),
                    ]);
                }

                $label = "Lístok: {$event->title} × {$qty}";
                $user->deduct($total, $label, $order);

                return $order;
            });
        } catch (\RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }

        $paid = number_format($total / 100, 2);

        // Send confirmation email with tickets
        try {
            $order->load('tickets.ticketType', 'event', 'user');
            Mail::to($user->email)->send(new TicketsPurchased($order));
        } catch (\Exception $e) {
            // Don't fail the purchase if mail fails — just log it
            logger()->error('Ticket email failed: ' . $e->getMessage());
        }

        return redirect()->route('orders.show', $order)
            ->with('success', "Lístky zakúpené za {$paid} €. Potvrdenie sme poslali na {$user->email}.");
    }
}