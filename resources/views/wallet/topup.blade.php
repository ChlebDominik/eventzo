@extends('layouts.app')
@section('title','Dobiť kredit')
@section('content')
<div style="max-width:440px;margin:0 auto;">

    <a href="{{ route('wallet.index') }}" style="display:inline-flex;align-items:center;gap:0.4rem;font-size:0.82rem;color:var(--muted);text-decoration:none;margin-bottom:1.75rem;transition:color 0.2s;" onmouseenter="this.style.color='var(--text)'" onmouseleave="this.style.color='var(--muted)'">
        ← Späť na peňaženku
    </a>

    <div class="fade-up" style="margin-bottom:2rem;">
        <h1 class="heading" style="font-size:2rem;">Dobiť kredit</h1>
        <p style="color:var(--muted);font-size:0.88rem;margin-top:0.4rem;">Testovací režim — žiadna skutočná platba</p>
    </div>

    <div class="card-glass fade-up fade-up-1" style="padding:2rem;">

        {{-- Current balance --}}
        <div style="display:flex;justify-content:space-between;align-items:center;padding:1rem 1.1rem;background:var(--surface2);border-radius:var(--radius-sm);border:1px solid var(--border);margin-bottom:1.75rem;">
            <span style="font-size:0.8rem;color:var(--muted);">Aktuálny zostatok</span>
            <span style="font-family:'Syne',sans-serif;font-weight:700;font-size:1.05rem;color:var(--violet2);">{{ auth()->user()->formattedBalance() }}</span>
        </div>

        <form method="POST" action="{{ route('wallet.topup') }}">
            @csrf

            {{-- Quick amounts --}}
            <p class="label" style="margin-bottom:0.75rem;">Rýchla voľba</p>
            <div style="display:grid;grid-template-columns:repeat(5,1fr);gap:0.5rem;margin-bottom:1.5rem;">
                @foreach([5,10,20,50,100] as $p)
                <button type="button" class="preset-btn" data-val="{{ $p }}"
                        style="padding:0.55rem 0;background:var(--surface2);border:1px solid var(--border);border-radius:var(--radius-sm);color:var(--muted2);font-size:0.85rem;font-weight:600;cursor:pointer;transition:all 0.15s;font-family:'Outfit',sans-serif;">
                    {{ $p }} €
                </button>
                @endforeach
            </div>

            <div class="field">
                <label class="label" for="amount">Vlastná suma (€)</label>
                <input type="number" name="amount" id="amount" step="0.01" min="1" max="10000"
                       value="{{ old('amount') }}" class="input @error('amount') error @enderror"
                       placeholder="0.00" required>
                @error('amount')<p style="font-size:0.78rem;color:var(--red);margin-top:0.4rem;">{{ $message }}</p>@enderror
            </div>

            <button type="submit" class="btn btn-primary btn-full btn-lg" style="margin-top:0.5rem;">Pridať kredit →</button>
        </form>
    </div>
</div>

<script>
document.querySelectorAll('.preset-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        document.getElementById('amount').value = btn.dataset.val;
        document.querySelectorAll('.preset-btn').forEach(b => {
            b.style.borderColor = 'var(--border)';
            b.style.color = 'var(--muted2)';
            b.style.background = 'var(--surface2)';
        });
        btn.style.borderColor = 'var(--violet)';
        btn.style.color = 'var(--violet2)';
        btn.style.background = 'var(--violet-dim)';
    });
});
</script>
@endsection