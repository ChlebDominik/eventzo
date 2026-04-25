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

    /** Manual code entry (form POST) */
    public function check(Request $request, Event $event)
    {
        $this->authorize('update', $event);
        $request->validate(['code' => 'required|string']);

        $result = $this->processTicket(trim($request->code), $event, $request->user()->id);

        return back()->with($result['ok'] ? 'checkin_success' : 'checkin_error', $result['message']);
    }

    /** Camera scanner (AJAX POST — returns JSON) */
    public function scan(Request $request, Event $event)
    {
        $this->authorize('update', $event);
        $request->validate(['code' => 'required|string']);

        $result = $this->processTicket(trim($request->code), $event, $request->user()->id);

        return response()->json($result);
    }

    /** Shared logic for both manual and camera check-in */
    private function processTicket(string $code, Event $event, int $userId): array
    {
        // Extract UUID from a signed URL if the scanner read a full URL
        if (str_contains($code, '/t/')) {
            preg_match('#/t/([^?]+)#', $code, $m);
            $code = $m[1] ?? $code;
        }

        $ticket = Ticket::with('order.event', 'ticketType', 'checkin')
            ->where('code', $code)
            ->first();

        if (! $ticket) {
            return ['ok' => false, 'message' => '❌ Lístok neexistuje.'];
        }

        if ($ticket->order->event_id !== $event->id) {
            return ['ok' => false, 'message' => '❌ Lístok nepatrí k tomuto eventu.'];
        }

        if ($ticket->isUsed()) {
            $at = $ticket->checkin?->checked_in_at?->format('d.m.Y H:i') ?? '?';
            return ['ok' => false, 'message' => "⚠️ Lístok už bol použitý ({$at})."];
        }

        DB::transaction(function () use ($ticket, $userId) {
            $ticket->update(['used_at' => now()]);
            $ticket->checkin()->create([
                'checked_in_by' => $userId,
                'checked_in_at' => now(),
            ]);
        });

        return [
            'ok'      => true,
            'message' => '✅ Vstup povolený — ' . $ticket->ticketType->name,
            'name'    => $ticket->ticketType->name,
        ];
    }
}