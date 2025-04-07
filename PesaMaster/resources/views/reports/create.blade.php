@extends('layouts.app')

@section('content')
    <h2>Generate Report</h2>
    @if(session('success'))
        <p>{{ session('success') }}</p>
    @endif
    <form action="{{ route('reports.store') }}" method="POST">
        @csrf
        <label for="type">Report Type:</label>
        <select name="type" required>
            <option value="income">Income</option>
            <option value="expenses">Expenses</option>
            <option value="profit">Profit</option>
            <option value="monthly_budget_progress">Monthly Budget Progress</option>
            <option value="crediting">Crediting</option>
            <option value="monthly_target_progress">Monthly Target Progress</option>
            <option value="failed_transactions">Failed Transactions</option>
        </select>
        <label for="period">Period (YYYY-MM):</label>
        <input type="month" name="period" required>
        <button type="submit">Generate Report</button>
    </form>
@endsection
