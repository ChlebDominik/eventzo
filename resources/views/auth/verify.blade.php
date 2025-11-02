@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-center align-items-center" style="min-height:65vh;">
    <div class="card p-4" style="max-width:720px; width:100%;">
        <h4 class="fw-bold mb-2">Overenie e-mailu</h4>
        <p class="muted mb-3">Pred pokračovaním prosím skontroluj svoj e-mail a klikni na overovací odkaz.</p>

        @if (session('status') == 'verification-link-sent')
            <div class="alert alert-success">Nový overovací odkaz bol odoslaný na tvoj e-mail.</div>
        @endif

        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="btn btn-primary">Poslať overovací e-mail znova</button>
        </form>

        <div class="mt-3 muted small">
            Ak si e-mail nedostal, skontroluj spam alebo pošli overovací e-mail znova.
        </div>
    </div>
</div>
@endsection
r