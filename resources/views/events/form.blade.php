<div class="mb-3">
  <label class="form-label">Názov</label>
  <input type="text" name="title" class="form-control" value="{{ old('title', $event->title ?? '') }}" required>
</div>

<div class="mb-3">
  <label class="form-label">Popis</label>
  <textarea name="description" class="form-control" rows="5">{{ old('description', $event->description ?? '') }}</textarea>
</div>

<div class="mb-3">
  <label class="form-label">Miesto</label>
  <input type="text" name="location" class="form-control" value="{{ old('location', $event->location ?? '') }}" required>
</div>

<div class="mb-3">
  <label class="form-label">Dátum a čas</label>
  <input type="datetime-local" name="start_date" class="form-control"
         value="{{ old('start_date', isset($event) ? \Carbon\Carbon::parse($event->start_date)->format('Y-m-d\TH:i') : '') }}" required>
</div>

<div class="mb-3">
  <label class="form-label">Kapacita</label>
  <input type="number" name="capacity" class="form-control" min="1" value="{{ old('capacity', $event->capacity ?? 1) }}" required>
</div>

<div class="mb-3">
  <label class="form-label">Obrázok (voliteľný)</label>
  <input type="file" name="image" class="form-control">
  @if(isset($event) && $event->image)
    <img src="{{ asset('storage/'.$event->image) }}" class="img-fluid mt-2" style="max-width:200px">
  @endif
</div>
