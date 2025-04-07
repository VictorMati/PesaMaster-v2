<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Budget;
use Illuminate\Support\Facades\Auth;

class BudgetController extends Controller
{
    /**
     * Display a listing of the budgets.
     */
    public function index()
    {
        $budgets = Budget::where('user_id', Auth::id())->orderBy('period', 'desc')->get();
        return view('budgets.index', compact('budgets'));
    }

    /**
     * Show the form for creating a new budget.
     */
    public function create()
    {
        return view('budgets.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'category' => 'required|string|max:255',
            'period' => 'required|date_format:Y-m',
            'limit' => 'required|numeric|min:0',
        ]);

        Budget::create([
            'user_id' => Auth::id(),
            'category' => $request->category,
            'period' => $request->period,
            'budget_limit' => $request->limit,
            'current_expense' => 0,
            'status' => 'active',
        ]);

        return redirect()->route('budgets.index')->with('success', 'Budget created successfully.');
    }

    /**
     * Display the specified budget.
     */
    public function show($id)
    {
        $budget = Budget::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        return view('budgets.show', compact('budget'));
    }

    /**
     * Show the form for editing a budget.
     */
    public function edit($id)
    {
        $budget = Budget::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        return view('budgets.edit', compact('budget'));
    }

    /**
     * Update the specified budget in storage.
     */
    public function update(Request $request, $id)
    {
        $budget = Budget::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        $request->validate([
            'period' => 'required|date_format:Y-m',
            'limit' => 'required|numeric|min:0',
        ]);

        $budget->update([
            'period' => $request->period,
            'limit' => $request->limit,
        ]);

        return redirect()->route('budgets.index')->with('success', 'Budget updated successfully.');
    }

    /**
     * Remove the specified budget from storage.
     */
    public function destroy($id)
    {
        $budget = Budget::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $budget->delete();

        return redirect()->route('budgets.index')->with('success', 'Budget deleted successfully.');
    }
}
