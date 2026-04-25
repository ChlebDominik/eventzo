<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::orderBy('start_date', 'asc')->paginate(9);
        return view('events.index', compact('events'));
    }

    public function show(Event $event)
    {
        $event->load('ticketTypes.tickets', 'organizer');
        return view('events.show', compact('event'));
    }

    public function create()
    {
        $this->authorize('create', Event::class);
        return view('events.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create', Event::class);

        $validated = $request->validate([
            'title'                   => 'required|string|max:255',
            'description'             => 'nullable|string',
            'location'                => 'required|string|max:255',
            'start_date'              => 'required|date',
            'image'                   => 'nullable|image|max:5120',
            'ticket_types'            => 'required|array|min:1',
            'ticket_types.*.name'     => 'required|string|max:255',
            'ticket_types.*.price'    => 'required|numeric|min:0',
            'ticket_types.*.quantity' => 'required|integer|min:1',
        ]);

        $validated['organizer_id'] = $request->user()->id;

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('events', 'public');
        }

        $event = Event::create($validated);

        foreach ($validated['ticket_types'] as $tt) {
            $event->ticketTypes()->create([
                'name'        => $tt['name'],
                'price_cents' => (int) round($tt['price'] * 100),
                'quantity'    => (int) $tt['quantity'],
            ]);
        }

        return redirect()->route('events.show', $event)->with('success', 'Event vytvorený.');
    }

    public function edit(Event $event)
    {
        $this->authorize('update', $event);
        $event->load('ticketTypes');
        return view('events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        $this->authorize('update', $event);

        $validated = $request->validate([
            'title'                   => 'required|string|max:255',
            'description'             => 'nullable|string',
            'location'                => 'required|string|max:255',
            'start_date'              => 'required|date',
            'image'                   => 'nullable|image|max:5120',
            'ticket_types'            => 'required|array|min:1',
            'ticket_types.*.name'     => 'required|string|max:255',
            'ticket_types.*.price'    => 'required|numeric|min:0',
            'ticket_types.*.quantity' => 'required|integer|min:1',
        ]);

        if ($request->hasFile('image')) {
            if ($event->image) {
                Storage::disk('public')->delete($event->image);
            }
            $validated['image'] = $request->file('image')->store('events', 'public');
        }

        $event->update($validated);

        $submittedIds = [];

        foreach ($validated['ticket_types'] as $tt) {
            $id = $tt['id'] ?? null;

            if ($id && $existing = $event->ticketTypes()->find($id)) {
                $existing->update([
                    'name'        => $tt['name'],
                    'price_cents' => (int) round($tt['price'] * 100),
                    'quantity'    => (int) $tt['quantity'],
                ]);
                $submittedIds[] = $existing->id;
            } else {
                $new = $event->ticketTypes()->create([
                    'name'        => $tt['name'],
                    'price_cents' => (int) round($tt['price'] * 100),
                    'quantity'    => (int) $tt['quantity'],
                ]);
                $submittedIds[] = $new->id;
            }
        }

        // Delete removed ticket types (only if no tickets sold for them)
        $event->ticketTypes()
              ->whereNotIn('id', $submittedIds)
              ->whereDoesntHave('tickets')
              ->delete();

        return redirect()->route('events.show', $event)->with('success', 'Event upravený.');
    }

    public function destroy(Event $event)
    {
        $this->authorize('delete', $event);

        if ($event->image) {
            Storage::disk('public')->delete($event->image);
        }

        $event->delete();
        return redirect()->route('events.index')->with('success', 'Event odstránený.');
    }
}