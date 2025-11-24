<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ config('app.name', 'Eventzo') }}</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    :root{
      --bg-1: #0f1724;
      --bg-2: #0b1020;
      --accent: #7c3aed;
      --accent-2: #06b6d4;
      --muted: #9ca3af;
    }
    html,body{height:100%}
    body {
      background: linear-gradient(180deg, var(--bg-1) 0%, var(--bg-2) 100%);
      color: #e6eef8;
      font-family: Inter, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
    }
    .navbar {
      background: rgba(255,255,255,0.02);
      border-bottom: 1px solid rgba(255,255,255,0.03);
      backdrop-filter: blur(6px);
    }
    .navbar-brand { font-weight:700; color:#fff !important; }
    .nav-link { color: rgba(230,238,248,0.85) !important; }
    .btn-primary {
      background: linear-gradient(90deg, var(--accent), var(--accent-2));
      border: none;
    }
    .card {
      background: linear-gradient(180deg, rgba(255,255,255,0.02), rgba(255,255,255,0.015));
      border: 1px solid rgba(255,255,255,0.03);
      color: #e6eef8;
      border-radius: 12px;
    }
    .muted { color: var(--muted); }
    .form-control, .form-select {
      background: rgba(255,255,255,0.02);
      border: 1px solid rgba(255,255,255,0.03);
      color: #eef6ff;
    }
    .form-control::placeholder { color: rgba(230,238,248,0.45); }
  </style>
</head>
<body>
  <nav class="navbar navbar-expand-lg py-3">
    <div class="container">
      <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
        <i class="bi bi-ticket-perforated-fill me-2" style="font-size:1.25rem;color:var(--accent)"></i>
        <span>Eventzo</span>
      </a>

      <button class="navbar-toggler btn btn-dark" type="button" data-bs-toggle="collapse" data-bs-target="#navMain">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navMain">
        <ul class="navbar-nav ms-auto align-items-center">
          <li class="nav-item me-3">
            <a class="nav-link" href="{{ route('events.index') }}">Eventy</a>
          </li>

          @auth
            <li class="nav-item dropdown me-3">
              <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
                <i class="bi bi-person-circle me-2" style="font-size:1.05rem"></i>
                {{ Auth::user()->name }}
              </a>
              <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end" style="min-width:160px;">
                <li><a class="dropdown-item" href="{{ route('events.index') }}">Dashboard</a></li>
                <li><hr class="dropdown-divider"></li>
                <li>
                  <form method="POST" action="{{ route('logout') }}" class="px-3">
                    @csrf
                    <button class="btn btn-sm btn-outline-light w-100" type="submit">Odhlásiť sa</button>
                  </form>
                </li>
              </ul>
            </li>
          @else
            <li class="nav-item me-2"><a class="btn btn-outline-light btn-sm" href="{{ route('login') }}">Prihlásiť sa</a></li>
            <li class="nav-item"><a class="btn btn-primary btn-sm" href="{{ route('register') }}">Vytvoriť účet</a></li>
          @endauth
        </ul>
      </div>
    </div>
  </nav>

  <div class="container my-5">
    @if(session('success'))
      <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif
    @if(session('error'))
      <div class="alert alert-danger text-center">{{ session('error') }}</div>
    @endif

    @yield('content')
  </div>

  <footer class="mt-5 py-4 text-center muted">
    © {{ date('Y') }} Eventzo — Tvoja platforma pre eventy
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
