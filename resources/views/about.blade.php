@extends('layouts.app')

@section('title', 'About EventZo')

@section('content')
<div class="container py-5">

    <div class="row justify-content-center">
        <div class="col-lg-8">

            <h1 class="mb-4 text-center">About EventZo</h1>

            <p class="lead text-center">
                EventZo is a modern web application designed for managing events quickly and efficiently.
            </p>

            <hr class="my-4">

            <h3>What is EventZo?</h3>
            <p>
                EventZo allows organizers to create events, manage participants,
                and generate digital tickets with QR codes. The system is built
                using Laravel framework and Bootstrap 5 to ensure security,
                responsiveness, and modern design.
            </p>

            <h3 class="mt-4">Main Features</h3>
            <ul>
                <li>User registration and authentication</li>
                <li>Create and manage events</li>
                <li>Participant registration</li>
                <li>QR code ticket generation</li>
                <li>Responsive design</li>
            </ul>

            <h3 class="mt-4">Technologies Used</h3>
            <ul>
                <li>Laravel (Backend)</li>
                <li>MySQL (Database)</li>
                <li>Bootstrap 5 (Frontend)</li>
                <li>Simple QR Code Package</li>
            </ul>

            <div class="text-center mt-5">
                <a href="{{ url('/') }}" class="btn btn-primary">
                    Back to Home
                </a>
            </div>

        </div>
    </div>

</div>
@endsection