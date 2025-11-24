@extends('layouts.app')

@section('content')
<div class="card p-4">
  <h4 class="mb-3">Upraviť event</h4>

  @if ($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form action="{{ route('events.update', $event) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    @include('events.form')

    <button class="btn btn-primary mt-3">Uložiť zmeny</button>
  </form>
</div>
@endsection
