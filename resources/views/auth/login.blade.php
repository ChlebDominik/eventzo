@extends('layouts.app')
@section('title','Prihlásenie')
@section('content')
<div class="fade-up" style="max-width:420px;margin:4rem auto;">
    <div style="text-align:center;margin-bottom:2rem;">
        <h1 class="heading" style="font-size:2.25rem;">Vitaj späť</h1>
        <p style="color:var(--muted);margin-top:0.5rem;font-size:0.9rem;">Prihlás sa do svojho účtu</p>
    </div>
    <div class="card-glass" style="padding:2rem;">
        @if($errors->any())
            <div class="alert alert-error">✕ {{ $errors->first() }}</div>
        @endif
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="field">
                <label class="label">Email</label>
                <input type="email" name="email" class="input" value="{{ old('email') }}" required autofocus>
            </div>
            <div class="field" style="margin-bottom:1.75rem;">
                <label class="label">Heslo</label>
                <input type="password" name="password" class="input" required>
            </div>
            <button type="submit" class="btn btn-primary btn-full btn-lg">Prihlásiť sa</button>
        </form>
    </div>
    <p style="text-align:center;margin-top:1.5rem;font-size:0.85rem;color:var(--muted);">
        Nemáš účet? <a href="{{ route('register') }}" style="color:var(--violet2);text-decoration:none;font-weight:600;">Registruj sa</a>
    </p>
</div>
@endsection