@extends('layouts.app')

@section('title', 'Prihlásenie')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-5">
        <h2 class="mb-4">Prihlásenie</h2>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Heslo</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <button class="btn btn-primary w-100">Prihlásiť</button>
        </form>
    </div>
</div>
@endsection
