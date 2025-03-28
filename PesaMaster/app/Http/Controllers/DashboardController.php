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
        $currentPeriod = Carbon::now()->format('Y-m');

        // Count daily transactions
        $dailyTransactionsCount = Transaction::where('user_id', $user->id)
            ->whereDate('created_at', Carbon::today())
            ->count();

        // Get latest transactions (last 5)
        $latestTransactions = Transaction::where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        // Get the latest report for the current period
        $report = Report::where('user_id', $user->id)
            ->where('period', $currentPeriod)
            ->first();

        $totalIncome = $report->total_income ?? 0; // Ensure it's not undefined
        $totalExpenses = $report->total_expenses ?? 0;

        // Get the user's budget for the current period
        $budget = Budget::where('user_id', $user->id)
            ->where('period', $currentPeriod)
            ->first();

        // Get income and expense data for the chart
        $chartData = Transaction::where('user_id', $user->id)
            ->whereMonth('created_at', Carbon::now()->month)
            ->selectRaw('DATE(created_at) as date,
                         SUM(CASE WHEN type = "income" THEN amount ELSE 0 END) as income,
                         SUM(CASE WHEN type = "expense" THEN amount ELSE 0 END) as expense')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $chartLabels = $chartData->pluck('date');
        $incomeData = $chartData->pluck('income');
        $expenseData = $chartData->pluck('expense');

        return view('dashboard', compact(
            'dailyTransactionsCount',
            'latestTransactions',
            'totalIncome',
            'totalExpenses',
            'budget',
            'chartLabels',
            'incomeData',
            'expenseData'
        ));
    }

}
