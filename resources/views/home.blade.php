@extends('layouts.app')

@section('title', 'EventZo')

@section('content')
<div class="p-5 rounded-4 bg-black border border-secondary">
    <h1 class="display-5 fw-bold mb-2">EventZo</h1>
    <p class="lead text-secondary mb-4">
        Vytváraj podujatia, spravuj registrácie a lístky s QR kódmi.
    </p>

    <div class="d-flex flex-wrap gap-2">
        <a href="{{ route('events.index') }}" class="btn btn-primary">Zobraziť eventy</a>

        @auth
            @if(auth()->user()->isOrganizer())
                <a href="{{ route('events.create') }}" class="btn btn-success">+ Vytvoriť event</a>
            @endif
        @else
            <a href="{{ route('register') }}" class="btn btn-outline-light">Vytvoriť účet</a>
        @endauth
    </div>
</div>

<div class="row mt-4 g-3">
    <div class="col-md-4">
        <div class="card bg-black border-secondary h-100">
            <div class="card-body">
                <h5 class="card-title">🎟️ Lístky + QR</h5>
                <p class="text-secondary mb-0">Generovanie QR kódov pre vstup a check-in.</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-black border-secondary h-100">
            <div class="card-body">
                <h5 class="card-title">📅 Správa eventov</h5>
                <p class="text-secondary mb-0">CRUD pre eventy len pre organizátorov.</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-black border-secondary h-100">
            <div class="card-body">
                <h5 class="card-title">✅ Check-in</h5>
                <p class="text-secondary mb-0">Overenie lístkov a označenie ako použitý.</p>
            </div>
        </div>
    </div>
</div>
@endsection
