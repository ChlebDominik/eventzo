@extends('layouts.app')

@section('title', $event->title)

@section('content')
<div class="row">
    <div class="col-md-8">
        <h2 class="mb-3">{{ $event->title }}</h2>

        @if($event->image)
            <img src="{{ asset('storage/'.$event->image) }}" class="img-fluid rounded mb-3">
        @endif

        @if($event->description)
            <p class="text-light">{{ $event->description }}</p>
        @endif

        <ul class="list-group list-group-flush mb-3">
            <li class="list-group-item bg-black text-light border-secondary">
                <strong>Miesto:</strong> {{ $event->location }}
            </li>
            <li class="list-group-item bg-black text-light border-secondary">
                <strong>Dátum:</strong> {{ $event->start_date }}
            </li>
            <li class="list-group-item bg-black text-light border-secondary">
                <strong>Organizátor:</strong> {{ $event->organizer->name ?? '-' }}
            </li>
        </ul>
    </div>

    <div class="col-md-4">
        <div class="card bg-black border-secondary">
            <div class="card-body">

                @guest
                    <a href="{{ route('login') }}" class="btn btn-primary w-100">
                        Prihlásiť sa a kúpiť lístok
                    </a>
                @else

                    @can('update', $event)
                        <a href="{{ route('events.edit', $event) }}" class="btn btn-warning w-100 mb-2">
                            Upraviť event
                        </a>

                        <a href="{{ route('checkin.index', $event) }}" class="btn btn-outline-light w-100 mb-2">
                            Check-in
                        </a>

                        <form method="POST" action="{{ route('events.destroy', $event) }}"
                              onsubmit="return confirm('Naozaj chceš vymazať tento event?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger w-100">Vymazať</button>
                        </form>

                    @else
                        @if($event->ticketTypes && $event->ticketTypes->count())
                            <form method="POST" action="{{ route('tickets.buy', $event) }}">
                                @csrf

                                <div class="mb-2">
                                    <label class="form-label text-secondary">Typ lístka</label>
                                    <select name="ticket_type_id" class="form-select" required>
                                        @foreach($event->ticketTypes as $type)
                                            <option value="{{ $type->id }}">
                                                {{ $type->name }} – {{ number_format($type->price_cents/100, 2) }} €
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label text-secondary">Počet</label>
                                    <input type="number" name="quantity" value="1" min="1" max="10"
                                           class="form-control" required>
                                </div>

                                <button class="btn btn-success w-100">Kúpiť lístok</button>
                            </form>
                        @else
                            <div class="alert alert-info mb-0">
                                Pre tento event nie sú ešte nastavené lístky.
                            </div>
                        @endif
                    @endcan

                @endguest

            </div>
        </div>
    </div>
</div>
@endsection
