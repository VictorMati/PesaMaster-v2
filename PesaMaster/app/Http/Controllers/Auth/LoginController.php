<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('auth.login'); // Ensure this file exists: resources/views/auth/login.blade.php
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'staff_no' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();
            dd($user->user_type);


            // Redirect based on user type
            if (strtolower($user->user_type) === 'admin') {
                return redirect()->intended(route('admin.dashboard'));
            }


            // Default: owner or other types
            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors([
            'staff_no' => 'The provided credentials are incorrect.',
        ])->onlyInput('staff_no');
    }


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect(route('login')); // Use named route for consistency
    }
}
