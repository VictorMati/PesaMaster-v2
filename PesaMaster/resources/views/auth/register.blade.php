<x-guest-layout>
    <head>
        <link rel="stylesheet" href="{{ asset('resources/css/register.css') }}">
    </head>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Owner Details -->
        <h2>Owner Details</h2>

        <div>
            <label for="staff_no">Staff No</label>
            <input id="staff_no" type="text" name="staff_no" value="{{ old('staff_no') }}" required autofocus>
            @error('staff_no')
                <p>{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="firstname">First Name</label>
            <input id="firstname" type="text" name="firstname" value="{{ old('firstname') }}" required>
            @error('firstname')
                <p>{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="lastname">Last Name</label>
            <input id="lastname" type="text" name="lastname" value="{{ old('lastname') }}" required>
            @error('lastname')
                <p>{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="email">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required>
            @error('email')
                <p>{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password">Password</label>
            <input id="password" type="password" name="password" required>
            @error('password')
                <p>{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password_confirmation">Confirm Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required>
        </div>

        <!-- Business Details -->
        <h2>Business Details</h2>

        <div>
            <label for="business_name">Business Name</label>
            <input id="business_name" type="text" name="business_name" value="{{ old('business_name') }}" required>
            @error('business_name')
                <p>{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="phone_number">Phone Number</label>
            <input id="phone_number" type="text" name="phone_number" value="{{ old('phone_number') }}" required>
            @error('phone_number')
                <p>{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="business_email">Business Email</label>
            <input id="business_email" type="email" name="business_email" value="{{ old('business_email') }}" required>
            @error('business_email')
                <p>{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="business_type">Business Type</label>
            <select id="business_type" name="business_type" required>
                <option value="retail">Retail</option>
                <option value="wholesale">Wholesale</option>
                <option value="manufacturing">Manufacturing</option>
            </select>
        </div>

        <div>
            <label for="address">Address</label>
            <input id="address" type="text" name="address" value="{{ old('address') }}">
        </div>

        <div>
            <button type="submit">Register</button>
        </div>

        <div>
            <a href="{{ route('login') }}">Already have an account? Login</a>
        </div>
    </form>
</x-guest-layout>
