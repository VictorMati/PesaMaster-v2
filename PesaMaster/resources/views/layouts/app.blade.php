<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/css/layout.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="layout-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <img src="{{ asset('images/logo.png') }}" alt="Company Logo" class="logo">
                <span class="company-name">{{ config('app.name', 'Laravel') }}</span>
                <button class="toggle-sidebar">☰</button>
            </div>
            <nav class="sidebar-nav">
                <ul>
                    <li><a href="{{ route('dashboard') }}"><i class="icon-dashboard"></i> Dashboard</a></li>
                    <li><a href="#"><i class="icon-transactions"></i> Transactions</a></li>
                    <li><a href="#"><i class="icon-wallet"></i> Accounts</a></li>
                    <li><a href="#"><i class="icon-budget"></i> Budget</a></li>
                    <li><a href="#"><i class="icon-savings"></i> Savings</a></li>
                    <li><a href="#"><i class="icon-investments"></i> Investments</a></li>
                    <li><a href="#"><i class="icon-reports"></i> Reports</a></li>
                    <li><a href="#"><i class="icon-user"></i> Profile</a></li>
                    <li><a href="#"><i class="icon-settings"></i> Settings</a></li>
                    <li><a href="#"><i class="icon-support"></i> Support</a></li>
                    <li>
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="icon-logout"></i> Logout
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
                    <button class="toggle-sidebar">☰</button>
                    <h1>Welcome, {{ Auth::user()->name ?? 'User' }}</h1>
                </div>
                <div class="header-right">
                    <input type="text" placeholder="Search..." class="search-bar">
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="icon-logout"></i>
                    </a>
                </div>
            </header>

            <!-- Page Content -->
            <main class="content">
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
