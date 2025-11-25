@extends('layouts.app')

@section('content')
<div class="hero mb-5">
  <div class="row align-items-center">
    <div class="col-lg-7">
      <h1 class="display-5 fw-bold" style="color:#fff">Organizuj a predávaj vstupenky s <span style="color:var(--accent)">Eventzo</span></h1>
      <p class="muted mt-3" style="max-width:680px">
        Moderná platforma pre organizátorov a návštevníkov. Vytvor event, sprav vstupenky, sleduj predaj a kontroluj vstupy cez QR.
      </p>

      <div class="mt-4">
        <a href="{{ route('events.index') }}" class="btn btn-primary btn-lg me-2">Prejsť na eventy</a>
        @guest
          <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg">Vytvoriť účet</a>
        @endguest
      </div>
    </div>

    <div class="col-lg-5 text-center mt-4 mt-lg-0">
      <div class="card p-3">
        <img src="/img/IMG.png" alt="event" class="img-fluid rounded" style="max-height:260px; object-fit:cover;">
        <div class="p-3">
          <h5 class="mb-1">Rap Concert</h5>
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
        <p class="muted small mb-0">Vytváraj eventy s popisom, dátumom, miestom a kapacitou.</p>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card p-4 h-100">
        <h5 class="fw-semibold">Registrácie a QR</h5>
        <p class="muted small mb-0">Účastníci dostanú lístok s QR kódom pre vstup.</p>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card p-4 h-100">
        <h5 class="fw-semibold">Marketing & štatistiky</h5>
        <p class="muted small mb-0">Zdieľaj eventy a sleduj záujem návštevníkov.</p>
      </div>
    </div>
  </div>
</section>
@endsection
