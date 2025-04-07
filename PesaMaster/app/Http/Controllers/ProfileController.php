<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{

    /**
     * Show the user profile with edit, password change, and picture upload.
     */
    public function index()
    {
        $user = Auth::user();
        return view('profile.index', compact('user'));
    }

    /**
     * Update profile information.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $user->update($request->only('firstname', 'lastname', 'email'));

        return redirect()->route('profile.index')->with('success', 'Profile updated successfully.');
    }


    /**
     * Update password.
     */
    public function updatePassword(Request $request)
    {
        // Ensure the user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'You must be logged in to update your password.');
        }

        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user(); // Now we are sure that the user is authenticated
        dd($user);
        // Check if the current password matches
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        // Update the password
        $user->update(['password' => Hash::make($request->new_password)]);

        return back()->with('success', 'Password updated successfully.');
    }

    /**
     * Upload profile picture.
     */
    public function updateProfilePicture(Request $request)
    {
        $request->validate([
            'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Get the authenticated user
        $user = Auth::user();

        // Delete old picture if exists
        if ($user->profile_picture) {
            Storage::delete('public/images/profile_pictures/' . $user->profile_picture);
        }

        // Store new profile picture
        $fileName = time() . '.' . $request->profile_picture->extension();
        $request->profile_picture->storeAs('public/images/profile_pictures', $fileName);

        // Update the user's profile picture
        $user->update(['profile_picture' => $fileName]);

        return back()->with('success', 'Profile picture updated successfully.');
    }

}
