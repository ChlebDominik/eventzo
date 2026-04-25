@extends('layouts.app')
@section('title','Nový event')
@section('content')
<div style="max-width:760px;">
    <div class="fade-up" style="margin-bottom:2rem;">
        <p class="label">Organizátor</p>
        <h1 class="heading" style="font-size:2.25rem;">Vytvoriť nový event</h1>
    </div>
    @if($errors->any())
        <div class="alert alert-error fade-up">
            @foreach($errors->all() as $e) <div>✕ {{ $e }}</div> @endforeach
        </div>
    @endif
    <div class="card fade-up fade-up-1">
        <div class="card-body">
            <form action="{{ route('events.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @include('events.form')
                <hr class="divider">
                <button class="btn btn-primary btn-lg">Vytvoriť event →</button>
            </form>
        </div>
    </div>
</div>
@endsection