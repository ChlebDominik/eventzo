@extends('layouts.app')

@section('title', 'Overenie lístka')

@section('content')
<h2>Overenie lístka</h2>

<ul class="list-group">
    <li class="list-group-item"><strong>Event:</strong> {{ $ticket->order->event->title }}</li>
    <li class="list-group-item"><strong>Typ:</strong> {{ $ticket->ticketType->name }}</li>
    <li class="list-group-item">
        <strong>Status:</strong>
        @if($ticket->isUsed())
            <span class="text-danger">Použitý</span>
        @else
            <span class="text-success">Platný</span>
        @endif
    </li>
</ul>
@endsection
