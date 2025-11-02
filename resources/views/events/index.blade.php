@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold">🎟️ Moje eventy</h3>
    <a href="{{ url('/eventy/create') }}" class="btn btn-primary">+ Vytvoriť nový event</a>
</div>

<div class="row g-4">
    {{-- TODO: neskôr sem načítame eventy z DB --}}
    <div class="col-12 text-center mt-5">
        <img src="https://cdn-icons-png.flaticon.com/512/1048/1048953.png" width="96" class="mb-3" style="opacity:0.8">
        <h5 class="muted">Zatiaľ nemáš žiadne podujatia.</h5>
        <p class="muted small">Klikni na „Vytvoriť nový event“ a pridaj svoje prvé podujatie.</p>
    </div>
</div>
@endsection
