@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-center align-items-center" style="min-height:70vh;">
    <div class="card p-4" style="width:100%; max-width:560px;">
        <div class="mb-3 text-center">
            <h4 class="fw-bold mb-0" style="color:#fff">Vytvoriť účet</h4>
            <p class="muted small mb-0">Zaregistruj sa a začni organizovať eventy</p>
        </div>

        @if($errors->any())
            <div class="alert alert-danger">{{ $errors->first() }}</div>
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

            <button type="submit" class="btn btn-primary w-100">Vytvoriť účet</button>
        </form>

        <div class="text-center mt-3 muted">
            Už máš účet? <a class="text-accent fw-semibold" href="{{ route('login') }}">Prihlásiť sa</a>
        </div>
    </div>
</div>
@endsection
