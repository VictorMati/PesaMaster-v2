<x-guest-layout>
    <head>
        @vite(['resources/css/login.css'])
    </head>
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Logo Section -->
        <div class="logo">
            <a href="/">
                <img src="{{ asset('images/logo.png') }}" alt="PesaMaster Logo" class="logo-image">
            </a>
        </div>

        <!-- Staff Number -->
        <div>
            <label for="staff_no">Staff Number</label>
            <input id="staff_no" type="text" name="staff_no" value="{{ old('staff_no') }}" required autofocus>
            @error('staff_no')
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

        <!-- Submit Button -->
        <div>
            <button type="submit">Sign in</button>
        </div>

        <!-- Forgot Password -->
        <div>
             <a href="{{ route('password.request') }}">Forgot your password?</a>
        </div>

        <!-- Registration Link -->
        <div>
            <a href="{{ route('register') }}">Don't have an account? Register</a>
        </div>
    </form>
</x-guest-layout>
