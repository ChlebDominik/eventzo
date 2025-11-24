@extends('layouts.app')

@section('content')
<div class="row">
  <div class="col-lg-8">
    <div class="card p-3">
      @if($event->image)
        <img src="{{ asset('storage/'.$event->image) }}" class="img-fluid rounded mb-3" style="max-height:420px;object-fit:cover;width:100%">
      @endif
      <h2 class="fw-bold">{{ $event->title }}</h2>
      <p class="muted small">{{ \Carbon\Carbon::parse($event->start_date)->format('d.m.Y H:i') }} · {{ $event->location }}</p>
      <p class="text-light mt-3">{{ $event->description }}</p>
    </div>

    <a href="{{ route('events.index') }}" class="btn btn-outline-light mt-3">Späť na eventy</a>
  </div>

  <div class="col-lg-4">
    <div class="card p-3">
      <h5>Detaily</h5>
      <p class="muted small mb-1">Kapacita: <strong>{{ $event->capacity }}</strong></p>
      <p class="muted small mb-1">Miesto: <strong>{{ $event->location }}</strong></p>
      <div class="mt-3">
        @auth
          <a href="{{ route('events.edit', $event) }}" class="btn btn-warning w-100 mb-2">Upraviť event</a>
          <form method="POST" action="{{ route('events.destroy', $event) }}" onsubmit="return confirm('Vymazať event?');">
            @csrf @method('DELETE')
            <button class="btn btn-danger w-100">Vymazať event</button>
          </form>
        @else
          <a href="{{ route('login') }}" class="btn btn-primary w-100">Prihlásiť sa pre nákup</a>
        @endauth
      </div>
    </div>
  </div>
</div>
@endsection
