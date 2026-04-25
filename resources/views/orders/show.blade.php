@extends('layouts.app')
@section('title', 'Objednávka #'.$order->id)
@section('content')
<div style="max-width:680px;margin:0 auto;">

    <a href="{{ route('events.show', $order->event) }}" style="display:inline-flex;align-items:center;gap:0.4rem;font-size:0.82rem;color:var(--muted);text-decoration:none;margin-bottom:1.75rem;transition:color 0.2s;" onmouseenter="this.style.color='var(--text)'" onmouseleave="this.style.color='var(--muted)'">
        ← Späť na event
    </a>

    {{-- Order header --}}
    <div class="card fade-up" style="margin-bottom:1rem;">
        <div class="card-body">
            <div style="display:flex;justify-content:space-between;align-items:flex-start;flex-wrap:wrap;gap:1rem;">
                <div>
                    <p class="label" style="margin-bottom:0.4rem;">Objednávka</p>
                    <h1 class="heading" style="font-size:1.75rem;">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</h1>
                </div>
                <span class="badge badge-green" style="font-size:0.75rem;padding:0.3rem 0.75rem;">✓ Zaplatená</span>
            </div>
            <hr class="divider" style="margin:1.25rem 0;">
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                <div>
                    <p class="label" style="margin-bottom:0.25rem;">Event</p>
                    <p style="font-size:0.95rem;font-weight:600;">{{ $order->event->title }}</p>
                </div>
                <div>
                    <p class="label" style="margin-bottom:0.25rem;">Celková suma</p>
                    <p style="font-size:0.95rem;font-weight:600;color:var(--violet2);">{{ number_format($order->total_cents/100,2) }} €</p>
                </div>
                <div>
                    <p class="label" style="margin-bottom:0.25rem;">Dátum nákupu</p>
                    <p style="font-size:0.88rem;color:var(--muted2);">{{ $order->created_at->format('d.m.Y o H:i') }}</p>
                </div>
                <div>
                    <p class="label" style="margin-bottom:0.25rem;">Počet lístkov</p>
                    <p style="font-size:0.88rem;color:var(--muted2);">{{ $order->tickets->count() }} ks</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Tickets --}}
    <p class="label fade-up fade-up-1" style="margin-bottom:0.75rem;">Tvoje lístky</p>
    <div style="display:flex;flex-direction:column;gap:0.625rem;">
        @foreach($order->tickets as $ticket)
        <div class="card fade-up fade-up-2" style="display:flex;align-items:center;justify-content:space-between;padding:1.1rem 1.5rem;flex-wrap:wrap;gap:0.75rem;">
            <div>
                <p style="font-weight:600;font-size:0.95rem;margin-bottom:0.25rem;">{{ $ticket->ticketType->name }}</p>
                <p style="font-size:0.75rem;color:var(--muted);font-family:monospace;letter-spacing:0.04em;">{{ $ticket->code }}</p>
            </div>
            <a href="{{ route('tickets.show', $ticket) }}" class="btn btn-primary btn-sm">QR kód →</a>
        </div>
        @endforeach
    </div>

</div>
@endsection