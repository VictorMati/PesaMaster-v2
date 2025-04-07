@extends('layouts.app')
@vite('resources/css/transaction.css')
@section('content')
    <div class="container">
        <main class="main-content">

            <h1>Transactions</h1>

            <!-- Filter Form -->
            <form method="GET" action="{{ route('transactions.index') }}">
                <div class="filter-container">
                    <div class="filter">
                        <select name="type" class="type-filter-selection">
                            <option value="">All Types</option>
                            <option value="deposit" {{ request('type') == 'deposit' ? 'selected' : '' }}>Deposit</option>
                            <option value="payment" {{ request('type') == 'payment' ? 'selected' : '' }}>Payment</option>
                        </select>
                    </div>
                    <div class="filter">
                        <input type="date" name="date" class="form-control" value="{{ request('date') }}">
                    </div>
                    <div class="filter">
                        <button type="submit">Filter</button>
                    </div>
                </div>
            </form>

            <!-- Transactions Table -->
            <!-- In your transactions.blade.php -->
            <div class="table-container">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Description</th>
                            <th>Type</th>
                            <th>Amount (Ksh.)</th>
                            <th>Account</th>
                            <th>Phone Number</th>
                            <th>Action</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transactions as $transaction)
                        <tr>
                            <td>{{ $transaction->created_at->format('d M Y') }}</td>
                            <td>{{ $transaction->description }}</td>
                            <td>
                                <span class="badge bg-{{ $transaction->type == 'deposit' ? 'success' : 'danger' }}">
                                    {{ ucfirst($transaction->type) }}
                                </span>
                            </td>
                            <td>{{ number_format($transaction->amount, 2) }}</td>
                            <td>{{ $transaction->account->name ?? 'N/A' }}</td>
                            <td>{{ $transaction->payment_method == 'mpesa' ? $transaction->phone_number : 'N/A' }}</td>
                            <td><a href="{{ route('transactions.show', $transaction->id) }}" class="btn btn-info btn-sm">View</a></td>
                            <td>
                                <form action="{{ route('transactions.destroy', $transaction->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" >Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">No transactions found.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            <div class="pagination-links">
                {{ $transactions->links() }}
            </div>
        </main>

@endsection
