@extends('layouts.app')
@section('title','Eventy')
@section('content')

<div class="fade-up" style="display:flex;align-items:flex-end;justify-content:space-between;margin-bottom:2.5rem;gap:1rem;flex-wrap:wrap;">
    <div>
        <p style="font-size:0.78rem;font-weight:700;letter-spacing:0.1em;text-transform:uppercase;color:var(--violet2);margin-bottom:0.4rem;">Nadchádzajúce</p>
        <h1 class="heading" style="font-size:2.75rem;">Eventy</h1>
    </div>
    @can('create', App\Models\Event::class)
        <a href="{{ route('events.create') }}" class="btn btn-primary">+ Nový event</a>
    @endcan
</div>

@forelse($events as $event)
<div class="card fade-up" style="display:flex;margin-bottom:0.875rem;min-height:150px;transition:border-color 0.2s,transform 0.2s;" onmouseenter="this.style.borderColor='var(--border2)';this.style.transform='translateY(-2px)'" onmouseleave="this.style.borderColor='var(--border)';this.style.transform='none'">
    {{-- Image --}}
    <div style="width:220px;flex-shrink:0;background:var(--surface2);display:flex;align-items:center;justify-content:center;overflow:hidden;">
        @if($event->image)
            <img src="{{ asset('storage/'.$event->image) }}" style="width:100%;height:100%;object-fit:cover;">
        @else
            <span style="font-size:2.75rem;opacity:0.3;">🎫</span>
        @endif
    </div>

    {{-- Content --}}
    <div style="padding:1.5rem;flex:1;display:flex;flex-direction:column;justify-content:space-between;min-width:0;">
        <div>
            <div style="display:flex;align-items:center;gap:0.75rem;margin-bottom:0.6rem;flex-wrap:wrap;">
                <h2 style="font-family:'Syne',sans-serif;font-size:1.1rem;font-weight:700;letter-spacing:-0.01em;">{{ $event->title }}</h2>
                @if($event->ticketTypes->count())
                    @if($event->totalAvailable() === 0)
                        <span class="badge badge-red">Vypredané</span>
                    @else
                        <span class="badge badge-green">Dostupné</span>
                    @endif
                @endif
            </div>
            <div class="stat-row" style="margin-bottom:0.75rem;">
                <span>📍 {{ $event->location }}</span>
                <span style="color:var(--border2);">·</span>
                <span>📅 {{ $event->start_date->format('d.m.Y H:i') }}</span>
                @if($event->musician)
                    <span style="color:var(--border2);">·</span>
                    <span>🎵 {{ $event->musician->name }}</span>
                @endif
                @if($event->musician)
                    <span style="color:var(--border2);">·</span>
                    <span>🎵 {{ $event->musician->name }}</span>
                @endif
                @if($event->ticketTypes->count())
                    <span style="color:var(--border2);">·</span>
                    <span>🎟 {{ $event->totalAvailable() }}/{{ $event->totalCapacity() }} miest</span>
                @endif
            </div>
            @if($event->description)
                <p style="font-size:0.85rem;color:var(--muted);line-height:1.6;margin:0;">{{ Str::limit($event->description, 130) }}</p>
            @endif
        </div>
        <div style="display:flex;align-items:center;justify-content:space-between;margin-top:1.25rem;flex-wrap:wrap;gap:0.5rem;">
            @if($event->ticketTypes->count())
                <span style="font-size:0.8rem;color:var(--muted);">od <strong style="color:var(--text);font-size:0.95rem;">{{ number_format($event->ticketTypes->min('price_cents')/100, 2) }} €</strong></span>
            @else
                <span></span>
            @endif
            <div style="display:flex;gap:0.5rem;">
                @can('update', $event)
                    <a href="{{ route('events.edit', $event) }}" class="btn btn-ghost btn-sm">Upraviť</a>
                @endcan
                <a href="{{ route('events.show', $event) }}" class="btn btn-primary btn-sm">Detail →</a>
            </div>
        </div>
    </div>
</div>
@empty
<div style="text-align:center;padding:6rem 0;" class="fade-up">
    <div style="font-size:4rem;margin-bottom:1rem;opacity:0.3;">🎫</div>
    <p style="color:var(--muted);font-size:0.95rem;">Zatiaľ žiadne eventy.</p>
</div>
@endforelse

<div style="margin-top:2rem;">{{ $events->links() }}</div>
@endsection