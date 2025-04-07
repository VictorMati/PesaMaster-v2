<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Account;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    public function index()
    {
        $accounts = Account::where('user_id', Auth::id())->get();
        return view('accounts.index', compact('accounts'));
    }

    public function show($id)
    {
        $account = Account::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        return view('accounts.show', compact('account'));
    }

    public function create()
    {
        return view('accounts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'balance' => 'required|numeric|min:0',
        ]);

        Account::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'balance' => $request->balance,
        ]);

        return redirect()->route('accounts.index')->with('success', 'Account added successfully.');
    }

    public function edit($id)
    {
        $account = Account::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        return view('accounts.edit', compact('account'));
    }

    public function update(Request $request, $id)
    {
        $account = Account::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        $request->validate([
            'name' => 'required|string|max:255',
            'balance' => 'required|numeric|min:0',
        ]);

        $account->update([
            'name' => $request->name,
            'balance' => $request->balance,
        ]);

        return redirect()->route('accounts.index')->with('success', 'Account updated successfully.');
    }

    public function destroy($id)
    {
        $account = Account::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $account->delete();

        return redirect()->route('accounts.index')->with('success', 'Account deleted successfully.');
    }
}
