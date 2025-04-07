@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Account Details</h1>
    <p><strong>Name:</strong> {{ $account->name }}</p>
    <p><strong>Balance:</strong> Ksh.{{ number_format($account->balance, 2) }}</p>

    <a href="{{ route('accounts.edit', $account->id) }}" class="btn btn-warning">Edit</a>
    <a href="{{ route('accounts.index') }}" class="btn btn-secondary">Back to Accounts</a>
</div>
@endsection
