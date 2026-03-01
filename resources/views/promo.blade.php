@extends('layouts.app')

@section('title', 'EventZo - Modern Event Management')

@section('content')

<!-- HERO SECTION -->
<section class="bg-dark text-white text-center py-5">
    <div class="container">
        <h1 class="display-4 fw-bold">EventZo</h1>
        <p class="lead">Moderné riešenie pre event managment a digital ticketing</p>
        <a href="{{ route('register') }}" class="btn btn-primary btn-lg mt-3">
            Začnime
        </a>
    </div>
</section>

<!-- FEATURES -->
<section class="py-5">
    <div class="container">
        <div class="row text-center">

            <div class="col-md-4">
                <h3>Vytvorte podujatia</h3>
                <p>Jednoducho manažujte a vytvarajte podujatia s plnou kontrolou nad účastnikmi a detailami.</p>
            </div>

            <div class="col-md-4">
                <h3>QR Lístky</h3>
                <p>Automaticky sa vygeneruje bezpečný QR kód pre rýchlý a bezdotykový vstup.</p>
            </div>

            <div class="col-md-4">
                <h3>Responzívny design</h3>
                <p>Prístup k ovládaciemu panelu z počítača, tabletu alebo mobilného zariadenia.</p>
            </div>

        </div>
    </div>
</section>

<!-- WHY CHOOSE US -->
<section class="bg-dark py-5">
    <div class="container text-center">
        <h2>Prečo si vybrať EventZo?</h2>
        <p class="mt-3">
            EventZo kombinuje jednoduchosť, bezpečnosť a flexibilitu.
Je vytvorený s využitím moderných technológií ako Laravel a Bootstrap,
čo zabezpečuje výkon a škálovateľnosť.
        </p>
    </div>
</section>

<!-- CALL TO ACTION -->
<section class="text-center py-5">
    <div class="container">
        <h2>Začnite spravovať svoje podujatia ešte dnes</h2>
        <a href="{{ route('register') }}" class="btn btn-success btn-lg mt-3">
            Vytvorte si účet
        </a>
    </div>
</section>

@endsection