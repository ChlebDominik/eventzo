@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
  <h3 class="fw-bold">🎟️ Eventy</h3>
  @auth
    <a href="{{ route('events.create') }}" class="btn btn-success">+ Vytvoriť nový event</a>
  @endauth
</div>

<div class="row g-4">
  @forelse($events as $event)
    <div class="col-md-4">
      <div class="card p-3 h-100">
        @if($event->image)
          <img src="{{ asset('storage/'.$event->image) }}" class="img-fluid rounded mb-3" style="height:180px;object-fit:cover;width:100%">
        @endif
        <h5>{{ $event->title }}</h5>
        <p class="muted small mb-1">{{ \Carbon\Carbon::parse($event->start_date)->format('d.m.Y H:i') }} · {{ $event->location }}</p>
        <p class="text-light small mb-3">{{ \Illuminate\Support\Str::limit($event->description, 120) }}</p>

        <div class="d-grid gap-2">
          <a href="{{ route('events.show', $event) }}" class="btn btn-primary">Zobraziť</a>
          @auth
            <a href="{{ route('events.edit', $event) }}" class="btn btn-outline-light">Upraviť</a>
          @endauth
        </div>
      </div>
    </div>
  @empty
    <div class="col-12 text-center mt-5">
      <img src="https://cdn-icons-png.flaticon.com/512/1048/1048953.png" width="96" class="mb-3" style="opacity:0.8">
      <h5 class="muted">Zatiaľ nemáme žiadne eventy.</h5>
      <p class="muted small">Pridaj svoje prvé podujatie.</p>
    </div>
  @endforelse
</div>

<div class="mt-4">
  {{ $events->links() }}
</div>
@endsection
