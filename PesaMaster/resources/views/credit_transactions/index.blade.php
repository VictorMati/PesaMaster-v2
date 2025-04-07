@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Credit Transactions</h1>
    <a href="{{ route('credit_transactions.create') }}">Add Transaction</a>
    <table>
        <tr>
            <th>Type</th>
            <th>Amount</th>
            <th>Description</th>
            <th>Actions</th>
        </tr>
        @foreach($creditTransactions as $transaction)
            <tr>
                <td>{{ $transaction->type }}</td>
                <td>{{ $transaction->amount }}</td>
                <td>{{ $transaction->description }}</td>
                <td>
                    <a href="{{ route('credit_transactions.show', $transaction->id) }}">View</a>
                </td>
            </tr>
        @endforeach
    </table>
</div>

@endsection
