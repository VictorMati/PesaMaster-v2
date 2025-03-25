<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'PesaMaster') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Figtree:wght@400;500;600&display=swap">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/guest_layout.css') }}">
</head>
<body>
    <div class="container">
        <!-- Logo Section -->
        <div class="logo">
            <a href="/">
                <img src="{{ asset('images/pesamasterlogo.png') }}" alt="PesaMaster Logo" class="logo-image">
            </a>
        </div>

        <!-- Main Content -->
        <div class="content-box">
            {{ $slot }}
        </div>
    </div>
</body>
</html>
