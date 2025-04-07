@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Credit Accounts</h1>
    <a href="{{ route('credit_accounts.create') }}">Add Credit Account</a>
    <table>
        <tr>
            <th>Credit Limit</th>
            <th>Current Balance</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
        @foreach($creditAccounts as $account)
            <tr>
                <td>{{ $account->credit_limit }}</td>
                <td>{{ $account->current_balance }}</td>
                <td>{{ $account->status }}</td>
                <td>
                    <a href="{{ route('credit_accounts.show', $account->id) }}">View</a>
                    <a href="{{ route('credit_accounts.edit', $account->id) }}">Edit</a>
                </td>
            </tr>
        @endforeach
    </table>
</div>

@endsection
