@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-center align-items-center" style="min-height:65vh;">
    <div class="card p-4" style="width:100%; max-width:520px;">
        <div class="mb-3 text-center">
            <h4 class="fw-bold mb-0">Prihlásenie</h4>
            <p class="muted small mb-0">Prihlás sa do svojho účtu Eventzo</p>
        </div>

        @if($errors->any())
            <div class="alert alert-danger">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" class="form-control" required autofocus>
            </div>

            <div class="mb-3">
                <label class="form-label">Heslo</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label muted" for="remember">Zapamätať si ma</label>
                </div>
                @if (Route::has('password.request'))
                    <a class="muted small" href="{{ route('password.request') }}">Zabudnuté heslo?</a>
                @endif
            </div>

            <button type="submit" class="btn btn-primary w-100">Prihlásiť sa</button>
        </form>

        <div class="text-center mt-3 muted">
            Nemáš účet? <a class="text-accent fw-semibold" href="{{ route('register') }}">Vytvoriť účet</a>
        </div>
    </div>
</div>
@endsection
