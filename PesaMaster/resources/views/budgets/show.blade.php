@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Budget Details</h1>

    <p><strong>Period:</strong> {{ $budget->period }}</p>
    <p><strong>Limit:</strong> Ksh. {{ number_format($budget->limit, 2) }}</p>
    <p><strong>Current Expenses:</strong> Ksh. {{ number_format($budget->current_expense, 2) }}</p>
    <p><strong>Status:</strong> {{ ucfirst($budget->status) }}</p>

    <a href="{{ route('budgets.index') }}" class="btn btn-secondary">Back</a>
    <a href="{{ route('budgets.edit', $budget->id) }}" class="btn btn-warning">Edit</a>
</div>
@endsection
