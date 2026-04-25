@extends('layouts.app')
@section('title','Lístok — '.$ticket->ticketType->name)
@section('content')
<div style="max-width:480px;margin:0 auto;text-align:center;">

    <a href="{{ route('orders.show', $ticket->order) }}" style="display:inline-flex;align-items:center;gap:0.4rem;font-size:0.82rem;color:var(--muted);text-decoration:none;margin-bottom:2rem;transition:color 0.2s;" onmouseenter="this.style.color='var(--text)'" onmouseleave="this.style.color='var(--muted)'">
        ← Späť na objednávku
    </a>

    <div class="card-glass fade-up" style="padding:2.5rem 2rem;text-align:center;">
        <span class="badge {{ $ticket->isUsed() ? 'badge-red' : 'badge-green' }}" style="margin-bottom:1.5rem;">
            {{ $ticket->isUsed() ? 'Použitý' : 'Platný' }}
        </span>

        <h1 class="heading" style="font-size:1.6rem;margin-bottom:0.4rem;">{{ $ticket->order->event->title }}</h1>
        <p style="color:var(--muted);font-size:0.88rem;margin-bottom:2rem;">{{ $ticket->ticketType->name }}</p>

        {{-- QR Code --}}
        <div style="background:#fff;display:inline-block;padding:1.25rem;border-radius:var(--radius);margin-bottom:1.5rem;box-shadow:0 0 40px rgba(124,92,252,0.2);">
            {!! $qrSvg !!}
        </div>

        <p style="font-family:monospace;font-size:0.8rem;color:var(--muted);letter-spacing:0.08em;word-break:break-all;">{{ $ticket->code }}</p>

        @if($ticket->isUsed())
            <div class="alert alert-error" style="margin-top:1.5rem;text-align:left;">
                ⚠️ Tento lístok bol už použitý pri vstupe.
            </div>
        @endif
    </div>

</div>
@endsection