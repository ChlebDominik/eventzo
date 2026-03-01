<!DOCTYPE html>
<html lang="sk" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'EventZo')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-black border-bottom border-secondary">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('home') }}">🎫 EventZo</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div id="nav" class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto align-items-center gap-2">

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('events.index') }}">Eventy</a>
                </li>
                <li class="nav-item">
    <a class="nav-link" href="{{ route('about') }}">About</a>
</li>
<li class="nav-item">
    <a class="nav-link" href="{{ route('promo') }}">Promo</a>
</li>
                @auth
                    
                    {{-- <li class="nav-item"><span class="nav-link text-warning">role={{ auth()->user()->role }}</span></li> --}}

                    @if(auth()->user()->isOrganizer())
                        <li class="nav-item">
                            <a class="btn btn-sm btn-success" href="{{ route('events.create') }}">
                                + Vytvoriť event
                            </a>
                        </li>
                    @endif

                    <li class="nav-item">
                        <span class="nav-link text-secondary">{{ auth()->user()->name }}</span>
                    </li>

                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="btn btn-sm btn-outline-danger">Odhlásiť</button>
                        </form>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="btn btn-sm btn-outline-light" href="{{ route('login') }}">Prihlásenie</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-sm btn-primary" href="{{ route('register') }}">Registrácia</a>
                    </li>
                @endauth

            </ul>
        </div>
    </div>
</nav>

<div class="container py-4">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
