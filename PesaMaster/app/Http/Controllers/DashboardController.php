<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Report;
use App\Models\Budget;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $currentPeriod = Carbon::now()->format('Y-m'); // e.g., "2025-03"

        // Get all transactions for the logged-in user
        $transactions = Transaction::where('user_id', $user->id)->get();

        // Get the latest report for the current period
        $report = Report::where('user_id', $user->id)
            ->where('period', $currentPeriod)
            ->first();

        $totalIncome = $report->total_income ?? 0;
        $totalExpenses = $report->total_expenses ?? 0;

        // Get the user's budget for the current period
        $budget = Budget::where('user_id', $user->id)
            ->where('period', $currentPeriod)
            ->first();

        return view('dashboard', compact('transactions', 'totalIncome', 'totalExpenses', 'budget'));
    }
}
