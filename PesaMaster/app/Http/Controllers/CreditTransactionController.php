<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CreditAccount;
use App\Models\CreditTransaction;
use Illuminate\Support\Facades\Auth;
class CreditTransactionController extends Controller
{
    public function index()
    {
        $transactions = CreditTransaction::with('creditAccount')
            ->whereHas('creditAccount', function ($query) {
                $query->where('user_id', Auth::id());
            })->get();

        return view('credit_transactions.index', compact('transactions'));
    }

    public function create()
    {
        $creditAccounts = CreditAccount::where('user_id', Auth::id())->get();
        return view('credit_transactions.create', compact('creditAccounts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'credit_account_id' => 'required|exists:credit_accounts,id',
            'type' => 'required|string',
            'amount' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        CreditTransaction::create($request->all());

        return redirect()->route('credit_transactions.index')->with('success', 'Transaction recorded successfully.');
    }
}
