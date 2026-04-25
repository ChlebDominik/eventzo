<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'EventZo')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=Outfit:wght@300;400;500;600&display=swap" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
        --bg:       #07070f;
        --surface:  #0f0f1a;
        --surface2: #16162a;
        --surface3: #1e1e32;
        --border:   rgba(255,255,255,0.07);
        --border2:  rgba(255,255,255,0.12);
        --text:     #f0eeff;
        --muted:    rgba(240,238,255,0.4);
        --muted2:   rgba(240,238,255,0.65);
        --violet:   #7c5cfc;
        --violet2:  #9b7dff;
        --violet-dim: rgba(124,92,252,0.15);
        --violet-glow: rgba(124,92,252,0.35);
        --green:    #22d3a5;
        --green-dim: rgba(34,211,165,0.12);
        --red:      #ff5e7d;
        --red-dim:  rgba(255,94,125,0.12);
        --amber:    #f5c842;
        --amber-dim: rgba(245,200,66,0.12);
        --radius:   14px;
        --radius-sm: 8px;
        --nav-h:    64px;
    }

    html { scroll-behavior: smooth; }

    body {
        background: var(--bg);
        color: var(--text);
        font-family: 'Outfit', sans-serif;
        font-weight: 400;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        -webkit-font-smoothing: antialiased;
        background-image:
            radial-gradient(ellipse 80% 50% at 50% -20%, rgba(124,92,252,0.12) 0%, transparent 60%);
    }

    /* ── NOISE TEXTURE ── */
    body::before {
        content: '';
        position: fixed;
        inset: 0;
        background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.04'/%3E%3C/svg%3E");
        pointer-events: none;
        z-index: 0;
        opacity: 0.5;
    }

    /* ── NAV ── */
    nav.ez-nav {
        position: sticky;
        top: 0;
        z-index: 200;
        height: var(--nav-h);
        background: rgba(7,7,15,0.8);
        backdrop-filter: blur(20px) saturate(180%);
        border-bottom: 1px solid var(--border);
    }
    .nav-inner {
        max-width: 1240px;
        margin: 0 auto;
        padding: 0 2rem;
        height: 100%;
        display: flex;
        align-items: center;
        gap: 2.5rem;
    }
    .ez-brand {
        font-family: 'Syne', sans-serif;
        font-weight: 800;
        font-size: 1.4rem;
        letter-spacing: -0.02em;
        text-decoration: none;
        color: var(--text);
        flex-shrink: 0;
        display: flex;
        align-items: center;
        gap: 0.4rem;
    }
    .ez-brand .dot {
        width: 7px; height: 7px;
        background: var(--violet);
        border-radius: 50%;
        display: inline-block;
        box-shadow: 0 0 10px var(--violet);
    }
    .nav-links { display: flex; align-items: center; gap: 0.25rem; flex: 1; }
    .nav-link {
        color: var(--muted);
        text-decoration: none;
        font-size: 0.875rem;
        font-weight: 500;
        padding: 0.4rem 0.9rem;
        border-radius: 8px;
        transition: color 0.2s, background 0.2s;
    }
    .nav-link:hover { color: var(--text); background: var(--surface2); }
    .nav-right { display: flex; align-items: center; gap: 0.75rem; margin-left: auto; }

    .nav-balance {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.35rem 0.85rem;
        background: var(--violet-dim);
        border: 1px solid rgba(124,92,252,0.3);
        border-radius: 8px;
        font-size: 0.83rem;
        font-weight: 600;
        color: var(--violet2);
        text-decoration: none;
        transition: background 0.2s, border-color 0.2s;
    }
    .nav-balance:hover { background: rgba(124,92,252,0.22); border-color: rgba(124,92,252,0.5); color: var(--violet2); }
    .nav-username { font-size: 0.8rem; color: var(--muted); }

    /* ── BUTTONS ── */
    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.4rem;
        font-family: 'Outfit', sans-serif;
        font-weight: 600;
        font-size: 0.875rem;
        padding: 0.55rem 1.25rem;
        border-radius: var(--radius-sm);
        border: none;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.2s;
        white-space: nowrap;
        position: relative;
        overflow: hidden;
    }
    .btn-primary {
        background: var(--violet);
        color: #fff;
        box-shadow: 0 0 0 0 var(--violet-glow);
    }
    .btn-primary:hover {
        background: var(--violet2);
        color: #fff;
        transform: translateY(-1px);
        box-shadow: 0 8px 25px var(--violet-glow);
    }
    .btn-ghost {
        background: transparent;
        color: var(--muted2);
        border: 1px solid var(--border2);
    }
    .btn-ghost:hover { color: var(--text); border-color: rgba(255,255,255,0.25); background: var(--surface2); }
    .btn-danger { background: var(--red-dim); color: var(--red); border: 1px solid rgba(255,94,125,0.25); }
    .btn-danger:hover { background: rgba(255,94,125,0.2); }
    .btn-success { background: var(--green-dim); color: var(--green); border: 1px solid rgba(34,211,165,0.25); }
    .btn-success:hover { background: rgba(34,211,165,0.2); }
    .btn-lg { padding: 0.75rem 1.75rem; font-size: 0.95rem; }
    .btn-sm { padding: 0.35rem 0.85rem; font-size: 0.78rem; }
    .btn-full { width: 100%; }

    /* ── PAGE ── */
    .page {
        max-width: 1240px;
        margin: 0 auto;
        padding: 2.5rem 2rem 5rem;
        flex: 1;
        position: relative;
        z-index: 1;
    }

    /* ── CARDS ── */
    .card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        overflow: hidden;
    }
    .card-body { padding: 1.75rem; }
    .card-glass {
        background: rgba(15,15,26,0.7);
        backdrop-filter: blur(20px);
        border: 1px solid var(--border2);
        border-radius: var(--radius);
    }

    /* ── FORM ELEMENTS ── */
    .field { margin-bottom: 1.25rem; }
    .label {
        display: block;
        font-size: 0.75rem;
        font-weight: 600;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: var(--muted);
        margin-bottom: 0.5rem;
    }
    .input {
        width: 100%;
        background: var(--surface2);
        border: 1px solid var(--border2);
        border-radius: var(--radius-sm);
        color: var(--text);
        padding: 0.7rem 1rem;
        font-family: 'Outfit', sans-serif;
        font-size: 0.9rem;
        outline: none;
        transition: border-color 0.2s, box-shadow 0.2s;
        -webkit-appearance: none;
    }
    .input:focus {
        border-color: var(--violet);
        box-shadow: 0 0 0 3px rgba(124,92,252,0.15);
    }
    .input.error { border-color: var(--red); }
    select.input { cursor: pointer; }
    select.input option { background: var(--surface2); }
    textarea.input { resize: vertical; min-height: 120px; }

    /* ── ALERTS ── */
    .alert {
        padding: 0.9rem 1.1rem;
        border-radius: var(--radius-sm);
        font-size: 0.875rem;
        margin-bottom: 1.5rem;
        border: 1px solid;
        display: flex;
        align-items: flex-start;
        gap: 0.6rem;
    }
    .alert-success { background: var(--green-dim); border-color: rgba(34,211,165,0.25); color: var(--green); }
    .alert-error   { background: var(--red-dim);   border-color: rgba(255,94,125,0.25);  color: var(--red); }
    .alert-info    { background: var(--violet-dim); border-color: rgba(124,92,252,0.25); color: var(--violet2); }

    /* ── BADGES ── */
    .badge {
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        font-size: 0.68rem;
        font-weight: 700;
        letter-spacing: 0.07em;
        text-transform: uppercase;
        padding: 0.2rem 0.6rem;
        border-radius: 4px;
    }
    .badge::before { content: ''; width: 5px; height: 5px; border-radius: 50%; background: currentColor; }
    .badge-green  { background: var(--green-dim);  color: var(--green);  border: 1px solid rgba(34,211,165,0.2); }
    .badge-red    { background: var(--red-dim);    color: var(--red);    border: 1px solid rgba(255,94,125,0.2); }
    .badge-violet { background: var(--violet-dim); color: var(--violet2); border: 1px solid rgba(124,92,252,0.2); }
    .badge-amber  { background: var(--amber-dim);  color: var(--amber);  border: 1px solid rgba(245,200,66,0.2); }

    /* ── HEADING ── */
    .heading {
        font-family: 'Syne', sans-serif;
        font-weight: 800;
        letter-spacing: -0.03em;
        line-height: 1.05;
    }

    /* ── DIVIDER ── */
    .divider { border: none; border-top: 1px solid var(--border); margin: 2rem 0; }

    /* ── STAT ROW ── */
    .stat-row {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
        align-items: center;
        font-size: 0.82rem;
        color: var(--muted);
    }
    .stat-row span { display: flex; align-items: center; gap: 0.3rem; }

    /* ── TICKET TYPE ROW (form) ── */
    .tt-row {
        display: grid;
        grid-template-columns: 1fr 140px 140px 44px;
        gap: 0.75rem;
        align-items: end;
        background: var(--surface2);
        border: 1px solid var(--border);
        border-radius: var(--radius-sm);
        padding: 1rem;
        margin-bottom: 0.75rem;
        transition: border-color 0.2s;
    }
    .tt-row:hover { border-color: var(--border2); }
    .tt-remove {
        background: var(--red-dim);
        border: 1px solid rgba(255,94,125,0.2);
        border-radius: var(--radius-sm);
        color: var(--red);
        font-size: 1rem;
        height: 42px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background 0.2s;
    }
    .tt-remove:hover { background: rgba(255,94,125,0.2); }

    /* ── TRANSACTION ROW ── */
    .tx-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1rem 1.25rem;
        border-bottom: 1px solid var(--border);
        gap: 1rem;
        transition: background 0.15s;
    }
    .tx-row:last-child { border-bottom: none; }
    .tx-row:hover { background: var(--surface2); }

    /* ── FOOTER ── */
    footer {
        border-top: 1px solid var(--border);
        text-align: center;
        padding: 1.5rem;
        font-size: 0.78rem;
        color: var(--muted);
        position: relative;
        z-index: 1;
    }

    /* ── ANIMATIONS ── */
    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(16px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .fade-up { animation: fadeUp 0.45s ease both; }
    .fade-up-1 { animation-delay: 0.05s; }
    .fade-up-2 { animation-delay: 0.12s; }
    .fade-up-3 { animation-delay: 0.19s; }
    .fade-up-4 { animation-delay: 0.26s; }
    </style>
</head>
<body>

<nav class="ez-nav">
    <div class="nav-inner">
        <a class="ez-brand" href="{{ route('home') }}">
            <span class="dot"></span>EventZo
        </a>
        <div class="nav-links">
            <a class="nav-link" href="{{ route('events.index') }}">Eventy</a>
        </div>
        <div class="nav-right">
            @auth
                @if(auth()->user()->isOrganizer())
                    <a class="btn btn-primary btn-sm" href="{{ route('events.create') }}">+ Nový event</a>
                @endif
                <a class="nav-balance" href="{{ route('wallet.index') }}">
                    💳 {{ auth()->user()->formattedBalance() }}
                </a>
                <span class="nav-username">{{ auth()->user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                    @csrf
                    <button class="btn btn-ghost btn-sm">Odhlásiť</button>
                </form>
            @else
                <a class="btn btn-ghost btn-sm" href="{{ route('login') }}">Prihlásenie</a>
                <a class="btn btn-primary btn-sm" href="{{ route('register') }}">Registrácia</a>
            @endauth
        </div>
    </div>
</nav>

<main class="page">
    @if(session('success'))
        <div class="alert alert-success fade-up">✓ {{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-error fade-up">✕ {{ session('error') }}</div>
    @endif
    @yield('content')
</main>

<footer>© {{ date('Y') }} EventZo — Tvoje lístky, tvoje eventy</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>