<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\Transaction;
use App\Models\Budget;
use App\Models\CreditTransaction;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReportController extends Controller
{
    /**
     * Display the report generation form.
     */
    public function create()
    {
        return view('reports.create');
    }

    /**
     * Generate a report based on the selected type and timeline.
     */
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|string',
            'period' => 'required|string',
        ]);

        $user = Auth::user();
        $period = Carbon::parse($request->period)->format('Y-m');

        $reportData = $this->fetchReportData($request->type, $user->id, $period);

        $report = Report::create([
            'user_id' => $user->id,
            'type' => $request->type,
            'total_income' => $reportData['total_income'] ?? 0,
            'total_expenses' => $reportData['total_expenses'] ?? 0,
            'status' => 'generated',
            'period' => $period,
        ]);

        return redirect()->route('reports.show', $report->id)->with('success', 'Report generated successfully.');
    }

    /**
     * Display a specific report.
     */
    public function show($id)
    {
        $report = Report::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        return view('reports.show', compact('report'));
    }

    /**
     * Fetch data for the report based on type.
     */
    private function fetchReportData($type, $userId, $period)
    {
        switch ($type) {
            case 'income':
                $totalIncome = Transaction::where('user_id', $userId)
                    ->where('type', 'income')
                    ->where('created_at', 'like', "$period%")
                    ->sum('amount');
                return ['total_income' => $totalIncome];

            case 'expenses':
                $totalExpenses = Transaction::where('user_id', $userId)
                    ->where('type', 'expense')
                    ->where('created_at', 'like', "$period%")
                    ->sum('amount');
                return ['total_expenses' => $totalExpenses];

            case 'profit':
                $totalIncome = Transaction::where('user_id', $userId)
                    ->where('type', 'income')
                    ->where('created_at', 'like', "$period%")
                    ->sum('amount');
                $totalExpenses = Transaction::where('user_id', $userId)
                    ->where('type', 'expense')
                    ->where('created_at', 'like', "$period%")
                    ->sum('amount');
                return ['total_income' => $totalIncome, 'total_expenses' => $totalExpenses, 'profit' => $totalIncome - $totalExpenses];

            case 'monthly_budget_progress':
                $budgets = Budget::where('user_id', $userId)
                    ->where('period', $period)
                    ->get();
                return ['budgets' => $budgets];

            case 'crediting':
                $creditTransactions = CreditTransaction::whereHas('creditAccount', function ($query) use ($userId) {
                        $query->where('user_id', $userId);
                    })
                    ->where('created_at', 'like', "$period%")
                    ->get();
                return ['credit_transactions' => $creditTransactions];

            case 'monthly_target_progress':
                // Assume we track progress toward some user-defined monthly financial goal
                $income = Transaction::where('user_id', $userId)
                    ->where('type', 'income')
                    ->where('created_at', 'like', "$period%")
                    ->sum('amount');
                return ['monthly_target_progress' => $income];

            case 'failed_transactions':
                $failedTransactions = Transaction::where('user_id', $userId)
                    ->where('status', 'failed')
                    ->where('created_at', 'like', "$period%")
                    ->get();
                return ['failed_transactions' => $failedTransactions];
        }
        return [];
    }
}
