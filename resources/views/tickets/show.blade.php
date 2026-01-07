@extends('layouts.app')

@section('title', 'Lístok')

@section('content')
<h2>{{ $ticket->order->event->title }}</h2>

<p>Typ: {{ $ticket->ticketType->name }}</p>

@if($ticket->isUsed())
    <div class="alert alert-warning">Ticket už bol použitý</div>
@endif

<div class="text-center">
    {!! $qrSvg !!}
    <p class="text-muted mt-2">{{ $ticket->code }}</p>
</div>
@endsection
