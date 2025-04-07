<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CreditAccount;
use App\Models\CreditTransaction;
use Illuminate\Support\Facades\Auth;

class CreditAccountController extends Controller
{
    public function index()
    {
        $creditAccounts = CreditAccount::where('user_id', Auth::id())->get();
        return view('credit_accounts.index', compact('creditAccounts'));
    }

    public function create()
    {
        return view('credit_accounts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'credit_limit' => 'required|numeric|min:0',
            'current_balance' => 'required|numeric|min:0',
            'status' => 'required|string',
        ]);

        CreditAccount::create([
            'user_id' => Auth::id(),
            'credit_limit' => $request->credit_limit,
            'current_balance' => $request->current_balance,
            'status' => $request->status,
        ]);

        return redirect()->route('credit_accounts.index')->with('success', 'Credit account created successfully.');
    }
}
