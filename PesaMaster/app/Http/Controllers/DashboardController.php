<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Report;
use App\Models\Budget;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $currentPeriod = Carbon::now()->format('Y-m');

        // Daily transactions
        $dailyTransactionsCount = Transaction::where('user_id', $user->id)
            ->whereDate('created_at', Carbon::today())
            ->count();

        // Latest transactions
        $latestTransactions = Transaction::where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        // Reports
        $report = Report::where('user_id', $user->id)
            ->where('period', $currentPeriod)
            ->first();

        $totalIncome   = $report->total_income ?? 0;
        $totalExpenses = $report->total_expenses ?? 0;

        // Budget
        $budget = Budget::where('user_id', $user->id)
            ->where('period', $currentPeriod)
            ->first();

        /* ===============================
           FIXED CHART DATA (IMPORTANT)
        =============================== */

        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth   = Carbon::now()->endOfMonth();

        // Get aggregated transaction data
        $transactions = Transaction::where('user_id', $user->id)
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->selectRaw('
                DATE(created_at) as date,
                SUM(CASE WHEN type = "income" THEN amount ELSE 0 END) as income,
                SUM(CASE WHEN type = "expense" THEN amount ELSE 0 END) as expense
            ')
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->keyBy('date'); // 🔑 key by date for fast lookup

        // Generate ALL dates in the month
        $period = CarbonPeriod::create($startOfMonth, $endOfMonth);

        $chartLabels = [];
        $incomeData  = [];
        $expenseData = [];

        foreach ($period as $date) {
            $dateKey = $date->format('Y-m-d');

            $chartLabels[] = $dateKey; // ISO format (Chart.js friendly)
            $incomeData[]  = (float) ($transactions[$dateKey]->income ?? 0);
            $expenseData[] = (float) ($transactions[$dateKey]->expense ?? 0);
        }

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
