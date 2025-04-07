@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Accounts</h1>
    <a href="{{ route('accounts.create') }}" class="btn btn-primary">Add New Account</a>

    @if($accounts->isEmpty())
        <p>No accounts found.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Balance</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($accounts as $account)
                    <tr>
                        <td>{{ $account->name }}</td>
                        <td>Ksh.{{ number_format($account->balance, 2) }}</td>
                        <td>
                            <a href="{{ route('accounts.show', $account->id) }}" class="btn btn-info">View</a>
                            <a href="{{ route('accounts.edit', $account->id) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('accounts.destroy', $account->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
