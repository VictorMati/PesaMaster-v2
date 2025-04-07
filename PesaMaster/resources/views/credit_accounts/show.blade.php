@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Credit Account Details</h1>
    <p>Credit Limit: {{ $creditAccount->credit_limit }}</p>
    <p>Current Balance: {{ $creditAccount->current_balance }}</p>
    <p>Status: {{ $creditAccount->status }}</p>
    <a href="{{ route('credit_accounts.index') }}">Back</a>
</div>

@endsection
