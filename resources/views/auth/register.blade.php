@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-center align-items-center" style="min-height:65vh;">
  <div class="card p-4" style="max-width:560px;width:100%">
    <h4 class="mb-3">Vytvoriť účet</h4>

    @if ($errors->any())
      <div class="alert alert-danger mb-3">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('register') }}">
      @csrf

      <div class="mb-3">
        <label class="form-label">Meno</label>
        <input type="text" name="name" value="{{ old('name') }}" class="form-control" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" value="{{ old('email') }}" class="form-control" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Heslo</label>
        <input type="password" name="password" class="form-control" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Potvrdiť heslo</label>
        <input type="password" name="password_confirmation" class="form-control" required>
      </div>

      <button class="btn btn-primary w-100" type="submit">Vytvoriť účet</button>
    </form>

    <div class="text-center muted mt-3">Už máš účet? <a class="text-accent fw-semibold" href="{{ route('login') }}">Prihlásiť sa</a></div>
  </div>
</div>
@endsection
