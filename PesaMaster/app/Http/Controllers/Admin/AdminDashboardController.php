<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Notification;
use App\Models\Log; // Optional: create a Log model/table for tracking events
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Fetch admin-related metrics
        $totalUsers = User::count();
        $recentUsers = User::latest()->take(5)->get();

        // If you have a logs table
        // $recentLogs = \DB::table('logs')->latest()->take(5)->get();

        return view('admin.dashboard', [
            'totalUsers' => $totalUsers,
            'recentUsers' => $recentUsers,
            // 'recentLogs' => $recentLogs
        ]);
    }

    public function viewSupportRequests()
    {
        $requests = Notification::with('user')
            ->where('type', 'support')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.support-requests', compact('requests'));
    }
}
