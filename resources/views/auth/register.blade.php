@extends('layouts.app')
@section('title','Registrácia')
@section('content')
<div class="fade-up" style="max-width:460px;margin:4rem auto;">
    <div style="text-align:center;margin-bottom:2rem;">
        <h1 class="heading" style="font-size:2.25rem;">Vytvoriť účet</h1>
        <p style="color:var(--muted);margin-top:0.5rem;font-size:0.9rem;">Začni nakupovať lístky ešte dnes</p>
    </div>
    <div class="card-glass" style="padding:2rem;">
        @if($errors->any())
            <div class="alert alert-error">
                @foreach($errors->all() as $e) <div>✕ {{ $e }}</div> @endforeach
            </div>
        @endif
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="field">
                <label class="label">Meno</label>
                <input type="text" name="name" class="input @error('name') error @enderror" value="{{ old('name') }}" required autofocus>
            </div>
            <div class="field">
                <label class="label">Email</label>
                <input type="email" name="email" class="input @error('email') error @enderror" value="{{ old('email') }}" required>
            </div>
            <div class="field">
                <label class="label">Heslo</label>
                <input type="password" name="password" class="input @error('password') error @enderror" required>
            </div>
            <div class="field">
                <label class="label">Heslo znovu</label>
                <input type="password" name="password_confirmation" class="input" required>
            </div>
            <div class="field" style="margin-bottom:1.75rem;">
                <label class="label">Typ účtu</label>
                <select name="role" class="input">
                    <option value="attendee">🎟️ Účastník — chcem kupovať lístky</option>
                    <option value="organizer">🎤 Organizátor — chcem vytvárať eventy</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary btn-full btn-lg">Vytvoriť účet</button>
        </form>
    </div>
    <p style="text-align:center;margin-top:1.5rem;font-size:0.85rem;color:var(--muted);">
        Už máš účet? <a href="{{ route('login') }}" style="color:var(--violet2);text-decoration:none;font-weight:600;">Prihlás sa</a>
    </p>
</div>
@endsection