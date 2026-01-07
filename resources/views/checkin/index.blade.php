@extends('layouts.app')

@section('title', 'Check-in')

@section('content')
<h2>Check-in – {{ $event->title }}</h2>

<form method="POST" action="{{ route('checkin.check', $event) }}">
    @csrf
    <div class="mb-3">
        <label class="form-label">Kód lístka</label>
        <input name="code" class="form-control" placeholder="UUID z QR" required>
    </div>

    <button class="btn btn-primary">Overiť</button>
</form>
@endsection
