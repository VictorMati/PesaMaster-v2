<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
        <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <!-- Styles -->
    @vite(['resources/css/layout.css', 'resources/js/layout.js'])
    <head>
        <!-- Other meta and link tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

        <!-- HTMX CDN -->
        <script src="https://unpkg.com/htmx.org@1.9.10"></script>

        <!-- Styles -->
        @vite(['resources/css/layout.css', 'resources/js/layout.js'])
    </head>

</head>
<body class="font-sans antialiased">
    @if (session('success') || session('error') || session('info') || $errors->any())
        <div id="notification"
            class="notification {{ session('success') ? 'success' : '' }} {{ session('error') || $errors->any() ? 'error' : '' }} {{ session('info') ? 'info' : '' }}"
            style="height: 50px; display:flex; align-items:center;">
            @if (session('success'))
                <i class="fa fa-check-circle"></i> {{ session('success') }}
            @elseif (session('error'))
                <i class="fa fa-times-circle"></i> {{ session('error') }}
            @elseif (session('info'))
                <i class="fa fa-info-circle"></i> {{ session('info') }}
            @elseif ($errors->any())
                <i class="fa fa-times-circle"></i> {{ $errors->first() }}
            @endif
        </div>

        <script>
            setTimeout(() => {
                const notification = document.getElementById('notification');
                if (notification) {
                    notification.classList.add('fade-out');
                    setTimeout(() => notification.remove(), 1000); // Optionally remove it after fade
                }
            }, 3000);
        </script>
    @endif


    <div class="layout-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <img src="{{ asset('images/logo.png') }}" alt="Company Logo" class="logo">
                <span class="company-name">{{ config('app.name', 'Laravel') }}</span>
                <button class="toggle-sidebar"><i class="fa fa-chevron-left" aria-hidden="true"></i></button>
            </div>
            <nav class="sidebar-nav">
                <ul>
                    <li><i class="fa-solid fa-chart-line"></i> <a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li><i class="fa-solid fa-money-bill-transfer"></i> <a href="{{ route('transactions.create') }}"> Add Transaction</a></li>
                    <li><i class="fa-solid fa-money-bill-transfer"></i> <a href="{{ route('transactions.index') }}"> Transactions</a></li>
                    <li><i class="fa-solid fa-wallet"></i><a href="{{ route('accounts.index') }}"> My Accounts</a></li>
                    <li><i class="fa-solid fa-bank"></i><a href="{{ route('credit_accounts.index') }}"> Credit</a></li>
                    <li><i class="fa-solid fa-coins"></i><a href="{{ route('budgets.index') }}"> Budget</a></li>

                    {{-- <li><i class="fa-solid fa-chart-pie"></i><a href="#"> Investments</a></li> --}}
                    <li><i class="fa-solid fa-file-invoice-dollar"></i><a href="{{ route('reports.create') }}"i> Reports</a></li>
                    <li><i class="fa-solid fa-headset"></i><a href="{{ route('support.form') }}"> Support</a></li>
                    {{-- <li><i class="fa-solid fa-fa-settings"></i><a href="#"> Settings</a></li> --}}
                    <li>
                        <i class="fa-solid fa-sign-out-alt"></i>
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Logout
                        </a>
                    </li>
                </ul>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                    @csrf
                </form>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Header Bar -->
            <header class="header-bar">
                <div class="header-left">
                    <h1>Welcome, {{ Auth::user()->firstname ?? 'User' }}</h1>
                </div>
                <!-- In your HTML header section -->
                <div class="header-right">
                    <form class="search-form" onsubmit="return false;">
                        <input
                            type="text"
                            name="query"
                            placeholder="Search for transactions, reports, credit accounts..."
                            class="search-bar"
                            autocomplete="off"
                            hx-get="{{ route('search') }}"
                            hx-trigger="keyup changed delay:300ms"
                            hx-target="#search-results"
                            hx-swap="innerHTML" onfocus="displayFunction()">
                    </form>



                    <div class="profile">
                        <img src="{{ asset('images/logo.png') }}" alt="profile image" class="profile-img">
                        <div class="profile-menu">
                            <a href="{{ route('profile.profile') }}" class="profile-link">
                                <i class="fa-solid fa-user"></i> Profile
                            </a>
                            <a href="#" class="profile-link">
                                <i class="fa-solid fa-gear"></i> Settings
                            </a>
                            <a href="{{ route('logout') }}" class="profile-link"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fa-solid fa-right-from-bracket"></i> Logout
                            </a>
                        </div>
                    </div>
                </div>
            </header>
            <script>
                displayFunction(){
                    const search = document.getElementById("search-results");
                        search.classList.add.style = "display: block;";
                }
            </script>

            <!-- Search Results Container -->
            <!-- Search Results Container -->
<div id="search-results" class="search-results-container" style="display: none;"></div>



            <!-- Page Content -->
            <main class="content">
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
