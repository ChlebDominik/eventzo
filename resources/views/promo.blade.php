@extends('layouts.app')

@section('title', 'EventZo - Modern Event Management')

@section('content')

<!-- HERO SECTION -->
<section class="bg-dark text-white text-center py-5">
    <div class="container">
        <h1 class="display-4 fw-bold">EventZo</h1>
        <p class="lead">Modern solution for event management and digital ticketing</p>
        <a href="{{ route('register') }}" class="btn btn-primary btn-lg mt-3">
            Get Started
        </a>
    </div>
</section>

<!-- FEATURES -->
<section class="py-5">
    <div class="container">
        <div class="row text-center">

            <div class="col-md-4">
                <h3>Create Events</h3>
                <p>Easily create and manage events with full control over participants and details.</p>
            </div>

            <div class="col-md-4">
                <h3>QR Tickets</h3>
                <p>Automatically generate secure QR codes for fast and contactless entry.</p>
            </div>

            <div class="col-md-4">
                <h3>Responsive Design</h3>
                <p>Access your dashboard from desktop, tablet, or mobile device.</p>
            </div>

        </div>
    </div>
</section>

<!-- WHY CHOOSE US -->
<section class="bg-dark py-5">
    <div class="container text-center">
        <h2>Why Choose EventZo?</h2>
        <p class="mt-3">
            EventZo combines simplicity, security, and flexibility.
            It is built using modern technologies like Laravel and Bootstrap,
            ensuring performance and scalability.
        </p>
    </div>
</section>

<!-- CALL TO ACTION -->
<section class="text-center py-5">
    <div class="container">
        <h2>Start Managing Your Events Today</h2>
        <a href="{{ route('register') }}" class="btn btn-success btn-lg mt-3">
            Create Free Account
        </a>
    </div>
</section>

@endsection