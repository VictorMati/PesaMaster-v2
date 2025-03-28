@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Transaction Details</h1>
        <div class="card">
            <div class="card-body">
                <p><strong>Date:</strong> {{ $transaction->created_at->format('d M Y, H:i A') }}</p>
                <p><strong>Description:</strong> {{ $transaction->description }}</p>
                <p><strong>Type:</strong>
                    <span class="badge bg-{{ $transaction->type == 'income' ? 'success' : 'danger' }}">
                        {{ ucfirst($transaction->type) }}
                    </span>
                </p>
                <p><strong>Amount:</strong> Ksh.{{ number_format($transaction->amount, 2) }}</p>
                <p><strong>Account:</strong> {{ $transaction->account->name ?? 'N/A' }}</p>
                <p><strong>Category:</strong> {{ $transaction->category->name ?? 'Uncategorized' }}</p>
            </div>
        </div>

        <a href="{{ route('transactions.index') }}" class="btn btn-secondary mt-3">Back to Transactions</a>
    </div>
@endsection
