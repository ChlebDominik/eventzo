@extends('layouts.app')

@section('title', 'Registrácia')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <h2 class="mb-4">Registrácia</h2>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">Meno</label>
                <input name="name" class="form-control" value="{{ old('name') }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Heslo</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Heslo znovu</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Typ účtu</label>
                <select name="role" class="form-select">
                    <option value="attendee">Účastník</option>
                    <option value="organizer">Organizátor</option>
                </select>
            </div>

            <button class="btn btn-primary w-100">Registrovať sa</button>
        </form>
    </div>
</div>
@endsection
