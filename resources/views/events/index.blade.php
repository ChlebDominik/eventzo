@extends('layouts.app')

@section('title', 'Eventy')

@section('content')
<h2 class="mb-4">Nadchádzajúce eventy</h2>

<div class="row">
@forelse($events as $event)
    <div class="col-md-4 mb-4">
        <div class="card bg-black border-secondary h-100">

            @if($event->image)
                <img src="{{ asset('storage/'.$event->image) }}" class="card-img-top">
            @endif

            <div class="card-body">
                <h5 class="card-title">{{ $event->title }}</h5>
                <p class="text-secondary">{{ $event->location }}</p>
                <p class="text-muted">{{ \Illuminate\Support\Str::limit($event->description, 90) }}</p>
            </div>

            <div class="card-footer bg-black border-top border-secondary">
                <a href="{{ route('events.show', $event) }}" class="btn btn-sm btn-primary">Detail</a>

                @can('update', $event)
                    <a href="{{ route('events.edit', $event) }}" class="btn btn-sm btn-warning">Upraviť</a>
                @endcan
            </div>
        </div>
    </div>
@empty
    <p>Žiadne eventy.</p>
@endforelse
</div>

{{ $events->links() }}
@endsection
