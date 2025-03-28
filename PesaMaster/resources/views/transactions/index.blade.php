@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">Transactions</h1>

        <!-- Filter Form -->
        <form method="GET" action="{{ route('transactions.index') }}" class="mb-4">
            <div class="row">
                <div class="col-md-4">
                    <select name="type" class="form-control">
                        <option value="">All Types</option>
                        <option value="income" {{ request('type') == 'income' ? 'selected' : '' }}>Income</option>
                        <option value="expense" {{ request('type') == 'expense' ? 'selected' : '' }}>Expense</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <input type="date" name="date" class="form-control" value="{{ request('date') }}">
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary">Filter</button>
                </div>
            </div>
        </form>

        <!-- Transactions Table -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Description</th>
                    <th>Type</th>
                    <th>Amount (Ksh.)</th>
                    <th>Account</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($transactions as $transaction)
                    <tr>
                        <td>{{ $transaction->created_at->format('d M Y') }}</td>
                        <td>{{ $transaction->description }}</td>
                        <td>
                            <span class="badge bg-{{ $transaction->type == 'income' ? 'success' : 'danger' }}">
                                {{ ucfirst($transaction->type) }}
                            </span>
                        </td>
                        <td>{{ number_format($transaction->amount, 2) }}</td>
                        <td>{{ $transaction->account->name ?? 'N/A' }}</td>
                        <td>
                            <a href="{{ route('transactions.show', $transaction->id) }}" class="btn btn-info btn-sm">View</a>
                            <form action="{{ route('transactions.destroy', $transaction->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">No transactions found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination -->
        {{ $transactions->links() }}
    </div>
@endsection
