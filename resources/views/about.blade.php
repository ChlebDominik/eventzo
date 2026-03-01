@extends('layouts.app')

@section('title', 'About EventZo')

@section('content')
<div class="container py-5">

    <div class="row justify-content-center">
        <div class="col-lg-8">

            <h1 class="mb-4 text-center">About EventZo</h1>

            <p class="lead text-center">
                EventZo je moderná webová aplikácia určená na rýchlu a efektívnu správu podujatí.
            </p>

            <hr class="my-4">

            <h3>Prečo EventZo?</h3>
            <p>
                EventZo umožňuje organizátorom vytvárať podujatia, spravovať účastníkov a generovať digitálne vstupenky s QR kódmi. Systém je vytvorený pomocou frameworku Laravel a Bootstrap 5, aby sa zabezpečila bezpečnosť, responzívnosť a moderný dizajn.
            </p>

            <h3 class="mt-4">Hlavné funkcie</h3>
            <ul>
                <li>Registrácia a autentifikácia použivateľov</li>
                <li>Vytvorenie a manažovanie podujatí</li>
                <li>Registrácia účastnikov</li>
                <li>Generácia QR kódov</li>
                
            </ul>

            <h3 class="mt-4">Použité technológie</h3>
            <ul>
                <li>Laravel (Backend)</li>
                <li>MySQL (Database)</li>
                <li>Bootstrap 5 (Frontend)</li>
                <li>Simple QR Code Package</li>
            </ul>

            <div class="text-center mt-5">
                <a href="{{ url('/') }}" class="btn btn-primary">
                    Späť home
                </a>
            </div>

        </div>
    </div>

</div>
@endsection