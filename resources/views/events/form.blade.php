<div class="field">
    <label class="label">Názov eventu</label>
    <input type="text" name="title" class="input" value="{{ old('title', $event->title ?? '') }}" placeholder="napr. Rock Fest 2026" required>
</div>

<div class="field">
    <label class="label">Popis</label>
    <textarea name="description" class="input" rows="4" placeholder="Povedz návštevníkom, o čom event je…">{{ old('description', $event->description ?? '') }}</textarea>
</div>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
    <div class="field">
        <label class="label">Miesto</label>
        <input type="text" name="location" class="input" value="{{ old('location', $event->location ?? '') }}" placeholder="Mesto, venue…" required>
    </div>
    <div class="field">
        <label class="label">Dátum a čas</label>
        <input type="datetime-local" name="start_date" class="input"
               value="{{ old('start_date', isset($event) ? \Carbon\Carbon::parse($event->start_date)->format('Y-m-d\TH:i') : '') }}" required>
    </div>
</div>

<div class="field">
    <label class="label">Titulný obrázok</label>
    <input type="file" name="image" class="input" accept="image/*">
    @if(isset($event) && $event->image)
        <div style="margin-top:0.75rem;">
            <img src="{{ asset('storage/'.$event->image) }}" style="height:80px;border-radius:6px;object-fit:cover;border:1px solid var(--border);">
            <p style="font-size:0.75rem;color:var(--muted);margin-top:0.35rem;">Nahrať nový obrázok ho nahradí.</p>
        </div>
    @endif
</div>

{{-- TICKET TYPES --}}
<hr class="divider">
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem;">
    <div>
        <p class="label" style="margin-bottom:0.2rem;">Typy lístkov</p>
        <p style="font-size:0.78rem;color:var(--muted);">Nastav cenu a počet kusov pre každý typ.</p>
    </div>
    <button type="button" class="btn btn-ghost btn-sm" id="addTT">+ Pridať typ</button>
</div>

<div id="ttContainer">
@if(isset($event) && $event->ticketTypes->count())
    @foreach($event->ticketTypes as $i => $type)
    <div class="tt-row">
        <input type="hidden" name="ticket_types[{{ $i }}][id]" value="{{ $type->id }}">
        <div class="field" style="margin:0;">
            <label class="label">Názov</label>
            <input type="text" name="ticket_types[{{ $i }}][name]" class="input" placeholder="Standard, VIP…" value="{{ old('ticket_types.'.$i.'.name', $type->name) }}" required>
        </div>
        <div class="field" style="margin:0;">
            <label class="label">Cena (€)</label>
            <input type="number" name="ticket_types[{{ $i }}][price]" class="input" step="0.01" min="0" placeholder="0.00" value="{{ old('ticket_types.'.$i.'.price', number_format($type->price_cents/100,2,'.','')) }}" required>
        </div>
        <div class="field" style="margin:0;">
            <label class="label">Počet kusov</label>
            <input type="number" name="ticket_types[{{ $i }}][quantity]" class="input" min="1" placeholder="100" value="{{ old('ticket_types.'.$i.'.quantity', $type->quantity) }}" required>
        </div>
        <button type="button" class="tt-remove">✕</button>
    </div>
    @endforeach
@else
    <div class="tt-row">
        <div class="field" style="margin:0;">
            <label class="label">Názov</label>
            <input type="text" name="ticket_types[0][name]" class="input" placeholder="Standard" required>
        </div>
        <div class="field" style="margin:0;">
            <label class="label">Cena (€)</label>
            <input type="number" name="ticket_types[0][price]" class="input" step="0.01" min="0" value="0.00" required>
        </div>
        <div class="field" style="margin:0;">
            <label class="label">Počet kusov</label>
            <input type="number" name="ticket_types[0][quantity]" class="input" min="1" value="100" required>
        </div>
        <button type="button" class="tt-remove">✕</button>
    </div>
@endif
</div>

<script>
(function(){
    const c = document.getElementById('ttContainer');
    document.getElementById('addTT').addEventListener('click', () => {
        const i = c.querySelectorAll('.tt-row').length;
        c.insertAdjacentHTML('beforeend', `
        <div class="tt-row">
            <div class="field" style="margin:0;">
                <label class="label">Názov</label>
                <input type="text" name="ticket_types[${i}][name]" class="input" placeholder="VIP, Standard…" required>
            </div>
            <div class="field" style="margin:0;">
                <label class="label">Cena (€)</label>
                <input type="number" name="ticket_types[${i}][price]" class="input" step="0.01" min="0" value="0.00" required>
            </div>
            <div class="field" style="margin:0;">
                <label class="label">Počet kusov</label>
                <input type="number" name="ticket_types[${i}][quantity]" class="input" min="1" value="100" required>
            </div>
            <button type="button" class="tt-remove">✕</button>
        </div>`);
    });
    c.addEventListener('click', e => {
        if(e.target.classList.contains('tt-remove')){
            const rows = c.querySelectorAll('.tt-row');
            if(rows.length > 1){ e.target.closest('.tt-row').remove(); reindex(); }
            else alert('Musíš mať aspoň jeden typ lístka.');
        }
    });
    function reindex(){
        c.querySelectorAll('.tt-row').forEach((row,i) => {
            row.querySelectorAll('[name]').forEach(el => {
                el.name = el.name.replace(/\[\d+\]/, `[${i}]`);
            });
        });
    }
})();
</script>