<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class SupportController extends Controller
{
    public function create()
    {
        return view('support.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000'
        ]);

        Notification::create([
            'user_id' => Auth::id(),
            'type' => 'support',
            'message' => $request->message,
            'read_status' => false
        ]);

        return redirect()->route('support.create')
            ->with('success', 'Your message has been sent to our support team.');
    }
}
