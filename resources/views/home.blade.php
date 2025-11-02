@extends('layouts.app')

@section('content')
<div class="hero mb-5">
    <div class="row align-items-center">
        <div class="col-lg-7">
            <h1 class="display-5 fw-bold" style="color: #fff">Organizuj a zdieľaj podujatia s <span style="color:var(--accent)">Eventzo</span></h1>
            <p class="muted mt-3" style="max-width:680px">
                Moderná platforma pre organizátorov a účastníkov. Vytvor event, pozvi ľudí a sprav registrácie vrátane QR lístkov.
            </p>

            <div class="mt-4">
                @guest
                    <a href="{{ route('register') }}" class="btn btn-primary btn-lg me-2">Vytvoriť účet</a>
                    <a href="{{ route('login') }}" class="btn btn-outline-light btn-lg">Prihlásiť sa</a>
                @else
                    <a href="{{ route('events.index') }}" class="btn btn-primary btn-lg">Moje eventy</a>
                @endguest
            </div>
        </div>

        <div class="col-lg-5 text-center mt-4 mt-lg-0">
            <div class="card p-3">
                <img src="https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?q=80&w=800&auto=format&fit=crop&ixlib=rb-4.0.3&s=7c2b3b2a6b4d3e2b9a3a5f0f7f8a1c2d" alt="event" class="img-fluid rounded" style="max-height:260px; object-fit:cover;">
                <div class="p-3">
                    <h5 class="mb-1">Blížiaci sa event: Summer Beats</h5>
                    <p class="muted small mb-0">Bratislava · 25. jún 2025</p>
                </div>
            </div>
        </div>
    </div>
</div>

<section class="mb-5">
    <div class="row g-4">
        <div class="col-md-4">
            <div class="card p-4 h-100">
                <h5 class="fw-semibold">Jednoduché vytváranie</h5>
                <p class="muted small mb-0">Rýchlo vytvoríš event s popisom, dátumom, miestom a kapacitou.</p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card p-4 h-100">
                <h5 class="fw-semibold">Registrácie a QR</h5>
                <p class="muted small mb-0">Účastníci dostanú potvrdenie a QR lístok pre vstup.</p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card p-4 h-100">
                <h5 class="fw-semibold">Marketing & štatistiky</h5>
                <p class="muted small mb-0">Zdieľaj eventy a sleduj záujem.</p>
            </div>
        </div>
    </div>
</section>
@endsection
