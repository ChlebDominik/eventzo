@extends('layouts.app')
@section('title','Upraviť event')
@section('content')
<div style="max-width:760px;">
    <div class="fade-up" style="margin-bottom:2rem;">
        <a href="{{ route('events.show', $event) }}" style="font-size:0.82rem;color:var(--muted);text-decoration:none;">← Späť na event</a>
        <h1 class="heading" style="font-size:2.25rem;margin-top:0.5rem;">Upraviť event</h1>
    </div>
    @if($errors->any())
        <div class="alert alert-error fade-up">
            @foreach($errors->all() as $e) <div>✕ {{ $e }}</div> @endforeach
        </div>
    @endif
    <div class="card fade-up fade-up-1">
        <div class="card-body">
            <form action="{{ route('events.update', $event) }}" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')
                @include('events.form')
                <hr class="divider">
                <button class="btn btn-primary btn-lg">Uložiť zmeny →</button>
            </form>
        </div>
    </div>
</div>
@endsection