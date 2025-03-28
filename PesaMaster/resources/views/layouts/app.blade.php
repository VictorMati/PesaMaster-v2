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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">


    <!-- Styles -->
    @vite(['resources/css/layout.css', 'resources/js/layout.js'])
</head>
<body class="font-sans antialiased">
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
                    <li><i class="fa-solid fa-money-bill-transfer"></i> <a href="{{ route('transactions.index') }}"> Transactions</a></li>
                    <li><i class="fa-solid fa-wallet"></i><a href="#"> Accounts</a></li>
                    <li><i class="fa-solid fa-coins"></i><a href="#"> Budget</a></li>
                    <li><i class="fa-solid fa-piggy-bank"></i><a href="#"> Savings</a></li>
                    <li><i class="fa-solid fa-chart-pie"></i><a href="#"> Investments</a></li>
                    <li><i class="fa-solid fa-file-invoice-dollar"></i><a href="#"i> Reports</a></li>
                    <li><i class="fa-solid fa-headset"></i><a href="#"> Support</a></li>
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
                <div class="header-right">
                    <input type="text" placeholder="Search..." class="search-bar">
                    <div class="profile">
                        <img src="{{ asset('images/logo.png') }}" alt="profile image">
                        <select name="profile-dropdown" id="profile-dropdown">
                            <option value="profile"><a href=" {{ route('profile.edit') }} ">profile</a><i class="icon-user"></i></option>
                            <option value="settings"><a href="">Settings</a><i class="icon-settings"></i></option>
                            <option value="logout"><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">logout</a>
                                <i class="icon-logout"></i></option>
                        </select>
                    </div>
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
