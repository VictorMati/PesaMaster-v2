<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel Admin') }}</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    @vite(['resources/css/layout.css', 'resources/js/layout.js'])
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
                    setTimeout(() => notification.remove(), 1000);
                }
            }, 3000);
        </script>
    @endif

    <div class="layout-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <img src="{{ asset('images/logo.png') }}" alt="Admin Logo" class="logo">
                <span class="company-name">Admin Panel</span>
                <button class="toggle-sidebar"><i class="fa fa-chevron-left" aria-hidden="true"></i></button>
            </div>
            <nav class="sidebar-nav">
                <ul>
                    <li><i class="fa-solid fa-tachometer-alt"></i> <a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li><i class="fa-solid fa-users"></i> <a href="{{ route('admin.users.index') }}">Manage Users</a></li>
                    <li><i class="fa-solid fa-database"></i> <a href="{{ route('admin.logs.index') }}">System Logs</a></li>
                    <li><i class="fa-solid fa-gear"></i> <a href="{{ route('admin.settings') }}">Site Settings</a></li>
                    <li><i class="fa-solid fa-message"></i> <a href="{{ route('admin.support') }}">Support Requests</a></li>
                    <li>
                        <i class="fa-solid fa-right-from-bracket"></i>
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Logout
                        </a>
                    </li>
                </ul>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="main-content">
            <header class="header-bar">
                <div class="header-left">
                    <h1>Welcome, Admin {{ Auth::user()->firstname ?? 'User' }}</h1>
                </div>
                <div class="header-right">
                    <input type="text" placeholder="Search..." class="search-bar">
                    <div class="profile">
                        <img src="{{ asset('images/logo.png') }}" alt="profile image" class="profile-img">
                        <div class="profile-menu">
                            <a href="{{ route('admin.profile') }}" class="profile-link"><i class="fa-solid fa-user"></i> Profile</a>
                            <a href="{{ route('admin.settings') }}" class="profile-link"><i class="fa-solid fa-gear"></i> Settings</a>
                            <a href="{{ route('logout') }}" class="profile-link"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fa-solid fa-right-from-bracket"></i> Logout
                            </a>
                        </div>
                    </div>
                </div>
            </header>

            <main class="content">
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
