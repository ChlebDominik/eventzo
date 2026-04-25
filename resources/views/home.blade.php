@extends('layouts.app')
@section('title', 'EventZo')
@section('content')

{{-- HERO --}}
<div class="fade-up" style="padding: 5rem 0 6rem; position: relative; text-align: center;">
    <div style="position:absolute;top:0;left:50%;transform:translateX(-50%);width:600px;height:300px;background:radial-gradient(ellipse, rgba(124,92,252,0.18) 0%, transparent 70%);pointer-events:none;"></div>
    <div class="badge badge-violet fade-up" style="margin-bottom:1.5rem;">🎫 Platforma pre eventy na Slovensku</div>
    <h1 class="heading fade-up fade-up-1" style="font-size: clamp(3rem,8vw,6.5rem); margin-bottom: 1.25rem; color: var(--text);">
        Zažívaj<br><span style="color:var(--violet2);">eventy</span> naplno.
    </h1>
    <p class="fade-up fade-up-2" style="font-size:1.05rem;color:var(--muted2);max-width:480px;margin:0 auto 2.5rem;line-height:1.75;">
        Nakupuj lístky, sleduj objednávky a vstup na podujatia jedným QR kódom.
    </p>
    <div class="fade-up fade-up-3" style="display:flex;gap:1rem;justify-content:center;flex-wrap:wrap;">
        <a href="{{ route('events.index') }}" class="btn btn-primary btn-lg">Zobraziť eventy →</a>
        @guest
            <a href="{{ route('register') }}" class="btn btn-ghost btn-lg">Vytvoriť účet</a>
        @endguest
    </div>
</div>

{{-- FEATURES --}}
<div class="fade-up fade-up-4" style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:1px;background:var(--border);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;margin-top:2rem;">
    @foreach([
        ['🎟️','Digitálne lístky','QR kódy pre každý lístok, vždy po ruke.'],
        ['📅','Správa eventov','Organizátori vytvárajú eventy v minútach.'],
        ['✅','Rýchly check-in','Overenie vstupenky naskenovaním QR kódu.'],
    ] as [$icon, $title, $desc])
    <div style="background:var(--surface);padding:2rem 1.75rem;transition:background 0.2s;" onmouseenter="this.style.background='var(--surface2)'" onmouseleave="this.style.background='var(--surface)'">
        <div style="font-size:1.75rem;margin-bottom:1rem;">{{ $icon }}</div>
        <div style="font-weight:600;font-size:0.9rem;margin-bottom:0.5rem;color:var(--text);">{{ $title }}</div>
        <div style="font-size:0.83rem;color:var(--muted);line-height:1.65;">{{ $desc }}</div>
    </div>
    @endforeach
</div>

@endsection