@extends('layouts.app')

@section('title', 'Objednávka')

@section('content')
<h2>Objednávka #{{ $order->id }}</h2>

<ul class="list-group mb-3">
    <li class="list-group-item"><strong>Event:</strong> {{ $order->event->title }}</li>
    <li class="list-group-item"><strong>Suma:</strong> {{ number_format($order->total_cents/100, 2) }} €</li>
</ul>

<h4>Lístky</h4>
<ul class="list-group">
@foreach($order->tickets as $ticket)
    <li class="list-group-item d-flex justify-content-between">
        {{ $ticket->ticketType->name }}
        <a href="{{ route('tickets.show', $ticket) }}" class="btn btn-sm btn-primary">QR</a>
    </li>
@endforeach
</ul>
@endsection
