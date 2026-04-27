<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Musician;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::with('ticketTypes', 'musicians')
            ->where('start_date', '>', now())
            ->orderBy('start_date', 'asc')
            ->paginate(9);
        return view('events.index', compact('events'));
    }

    public function show(Event $event)
    {
        $event->load('ticketTypes.tickets', 'organizer', 'musicians');
        return view('events.show', compact('event'));
    }

    public function create()
    {
        $this->authorize('create', Event::class);
        $musicians = Musician::orderBy('name')->get();
        return view('events.create', compact('musicians'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Event::class);

        $validated = $request->validate([
            'title'                   => 'required|string|max:255',
            'description'             => 'nullable|string',
            'location'                => 'required|string|max:255',
            'start_date'              => 'required|date|after:now',
            'image'                   => 'nullable|image|max:5120',
            'ticket_types'            => 'required|array|min:1',
            'ticket_types.*.name'     => 'required|string|max:255',
            'ticket_types.*.price'    => 'required|numeric|min:0',
            'ticket_types.*.quantity' => 'required|integer|min:1',
            'musicians'               => 'nullable|array',
            'musicians.*.id'          => 'nullable|exists:musicians,id',
            'musicians.*.name'        => 'required_without:musicians.*.id|string|max:255',
            'musicians.*.genre'       => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('events', 'public');
        }

        $validated['organizer_id'] = $request->user()->id;
        $event = Event::create($validated);

        foreach ($validated['ticket_types'] as $tt) {
            $event->ticketTypes()->create([
                'name'        => $tt['name'],
                'price_cents' => (int) round($tt['price'] * 100),
                'quantity'    => (int) $tt['quantity'],
            ]);
        }

        $this->syncMusicians($event, $request->input('musicians', []));

        return redirect()->route('events.show', $event)->with('success', 'Event vytvorený.');
    }

    public function edit(Event $event)
    {
        $this->authorize('update', $event);
        $event->load('ticketTypes', 'musicians');
        $musicians = Musician::orderBy('name')->get();
        return view('events.edit', compact('event', 'musicians'));
    }

    public function update(Request $request, Event $event)
    {
        $this->authorize('update', $event);

        $validated = $request->validate([
            'title'                   => 'required|string|max:255',
            'description'             => 'nullable|string',
            'location'                => 'required|string|max:255',
            'start_date'              => 'required|date|after:now',
            'image'                   => 'nullable|image|max:5120',
            'ticket_types'            => 'required|array|min:1',
            'ticket_types.*.name'     => 'required|string|max:255',
            'ticket_types.*.price'    => 'required|numeric|min:0',
            'ticket_types.*.quantity' => 'required|integer|min:1',
            'musicians'               => 'nullable|array',
            'musicians.*.id'          => 'nullable|exists:musicians,id',
            'musicians.*.name'        => 'required_without:musicians.*.id|string|max:255',
            'musicians.*.genre'       => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('image')) {
            if ($event->image) Storage::disk('public')->delete($event->image);
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
        $event->ticketTypes()->whereNotIn('id', $submittedIds)->whereDoesntHave('tickets')->delete();

        $this->syncMusicians($event, $request->input('musicians', []));

        return redirect()->route('events.show', $event)->with('success', 'Event upravený.');
    }

    public function destroy(Event $event)
    {
        $this->authorize('delete', $event);
        if ($event->image) Storage::disk('public')->delete($event->image);
        $event->delete();
        return redirect()->route('events.index')->with('success', 'Event odstránený.');
    }

    /** Sync musicians — create new ones if needed, then attach all with order */
    private function syncMusicians(Event $event, array $musicians): void
    {
        $syncData = [];

        foreach ($musicians as $i => $m) {
            if (!empty($m['id'])) {
                $syncData[$m['id']] = ['order' => $i];
            } elseif (!empty($m['name'])) {
                // New custom musician — create and attach
                $musician = Musician::firstOrCreate(
                    ['name' => trim($m['name'])],
                    ['genre' => trim($m['genre'] ?? '')]
                );
                $syncData[$musician->id] = ['order' => $i];
            }
        }

        $event->musicians()->sync($syncData);
    }
}