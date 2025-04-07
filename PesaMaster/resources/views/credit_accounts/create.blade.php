@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Add Credit Account</h1>
    <form method="POST" action="{{ route('credit_accounts.store') }}">
        @csrf
        <label>Credit Limit:</label>
        <input type="number" name="credit_limit" required>
        <label>Current Balance:</label>
        <input type="number" name="current_balance" required>
        <label>Status:</label>
        <select name="status">
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
        </select>
        <button type="submit">Create</button>
    </form>
</div>

@endsection
