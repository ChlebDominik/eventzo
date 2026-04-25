@extends('layouts.app')
@section('title','Peňaženka')
@section('content')
<div style="max-width:680px;margin:0 auto;">

    {{-- Balance hero --}}
    <div class="card-glass fade-up" style="padding:2.5rem;margin-bottom:1.5rem;position:relative;overflow:hidden;">
        <div style="position:absolute;top:-40px;right:-40px;width:220px;height:220px;background:radial-gradient(circle, rgba(124,92,252,0.15) 0%, transparent 70%);pointer-events:none;"></div>
        <p class="label" style="margin-bottom:0.5rem;">Aktuálny zostatok</p>
        <h1 class="heading" style="font-size:3.5rem;color:var(--violet2);line-height:1;">{{ $user->formattedBalance() }}</h1>
        <p style="color:var(--muted);font-size:0.83rem;margin-top:0.5rem;margin-bottom:2rem;">Testovací kredit — žiadne reálne platby</p>
        <a href="{{ route('wallet.topup') }}" class="btn btn-primary btn-lg">+ Dobiť kredit</a>
    </div>

    {{-- Transactions --}}
    <p class="label fade-up fade-up-1" style="margin-bottom:0.75rem;">História transakcií</p>

    @if($transactions->isEmpty())
        <div class="card fade-up fade-up-2" style="padding:3rem;text-align:center;">
            <p style="color:var(--muted);font-size:0.9rem;">Zatiaľ žiadne transakcie.</p>
        </div>
    @else
        <div class="card fade-up fade-up-2">
            @foreach($transactions as $tx)
            <div class="tx-row">
                <div style="display:flex;align-items:center;gap:0.9rem;">
                    <div style="width:36px;height:36px;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:1rem;background:{{ $tx->amount_cents >= 0 ? 'var(--green-dim)' : 'var(--red-dim)' }};">
                        {{ $tx->amount_cents >= 0 ? '↓' : '↑' }}
                    </div>
                    <div>
                        <p style="font-size:0.88rem;font-weight:500;margin-bottom:0.15rem;">{{ $tx->description }}</p>
                        <p style="font-size:0.75rem;color:var(--muted);">{{ $tx->created_at->format('d.m.Y H:i') }}</p>
                    </div>
                </div>
                <span style="font-family:'Syne',sans-serif;font-size:1rem;font-weight:700;color:{{ $tx->amount_cents >= 0 ? 'var(--green)' : 'var(--red)' }};">
                    {{ $tx->formattedAmount() }}
                </span>
            </div>
            @endforeach
        </div>
        <div style="margin-top:1.5rem;">{{ $transactions->links() }}</div>
    @endif

</div>
@endsection