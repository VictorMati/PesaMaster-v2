<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Account;
use App\Models\MpesaTransaction;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class TransactionController extends Controller
{
    /**
     * Display a list of transactions.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        // Filtering logic
        $query = Transaction::where('user_id', $user->id);

        if ($request->has('type') && in_array($request->type, ['deposit', 'payment'])) {
            $query->where('type', $request->type);
        }

        if ($request->has('date')) {
            $query->whereDate('created_at', Carbon::parse($request->date));
        }

        $transactions = $query->latest()->paginate(10);

        return view('transactions.index', compact('transactions'));
    }

    /**
     * Show details of a specific transaction.
     */
    public function show($id)
    {
        $transaction = Transaction::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('transactions.show', compact('transaction'));
    }

    /**
     * Delete a transaction.
     */
    public function destroy($id)
    {
        $transaction = Transaction::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $transaction->delete();

        return redirect()->route('transactions.index')
            ->with('success', 'Transaction deleted successfully.');
    }

    /**
     * Show form to create a new transaction.
     */
    public function create()
    {
        return view('transactions.create');
    }

    /**
     * Store a newly created transaction.
     */
    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1|max:150000',
            'type' => 'required|in:deposit,payment',
            'payment_method' => 'required|in:cash,mpesa',
            'phone_number' => 'nullable|required_if:payment_method,mpesa|regex:/^0[1]\d{8}$/', // Kenyan format validation
            'description' => 'nullable|string|max:255',
        ]);

        $user = Auth::user();

        // Create the base transaction record
        $transaction = Transaction::create([
            'user_id' => $user->id,
            'amount' => $request->amount,
            'type' => $request->type,
            'payment_method' => $request->payment_method,
            'phone_number' => $request->phone_number,
            'description' => $request->description,
            'transaction_date' => now(),
            'status' => $request->payment_method == 'cash' ? 'completed' : 'pending',
        ]);

        // For cash transactions, we're done
        if ($request->payment_method == 'cash') {
            return redirect()->route('transactions.index')
                ->with('success', 'Cash transaction recorded successfully!');
        }



        if ($request->payment_method == 'mpesa') {
            // Trigger the STK push via internal POST request
            app(\App\Http\Controllers\MpesaTransactionController::class)
            ->stkPush(new Request([
                'transaction_id' => $transaction->id,
                'phone' => $request->phone_number,
                'amount' => $request->amount
            ]));


            return redirect()->route('transactions.index')
                ->with('success', 'M-Pesa STK Push sent. Please check your phone to complete payment.');
        }

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }
}
