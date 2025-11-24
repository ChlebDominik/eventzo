@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-center align-items-center" style="min-height:60vh;">
  <div class="card p-4" style="max-width:520px;width:100%">
    <h4 class="mb-3">Prihlásenie</h4>

    @if ($errors->any())
      <div class="alert alert-danger mb-3">{{ $errors->first() }}</div>
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
        <a href="#" class="muted small">Zabudnuté heslo?</a>
      </div>

      <button class="btn btn-primary w-100" type="submit">Prihlásiť sa</button>
    </form>

    <div class="text-center muted mt-3">Nemáš účet? <a class="text-accent fw-semibold" href="{{ route('register') }}">Vytvoriť účet</a></div>
  </div>
</div>
@endsection
