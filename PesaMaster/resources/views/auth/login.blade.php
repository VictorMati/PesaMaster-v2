<x-guest-layout>
    <head>
        <link rel="stylesheet" href="{{ asset('resources/css/login.css') }}">
    </head>
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
            @error('email')
                <p>{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div>
            <label for="password">Password</label>
            <input id="password" type="password" name="password" required>
            @error('password')
                <p>{{ $message }}</p>
            @enderror
        </div>

        <!-- Remember Me -->
        <div>
            <label>
                <input type="checkbox" name="remember"> Remember Me
            </label>
        </div>

        <div>
            <a href="{{ route('password.request') }}">Forgot your password?</a>
        </div>

        <div>
            <button type="submit">Login</button>
        </div>

        <div>
            <a href="{{ route('register') }}">Don't have an account? Register</a>
        </div>
    </form>
</x-guest-layout>
