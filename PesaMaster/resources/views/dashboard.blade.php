@extends('layouts.app')

@section('content')
    {{-- <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}"> --}}
    @vite('resources/css/dashboard.css')

    <div class="dashboard-container">
        {{-- <aside class="sidebar">
            <h2>Menu</h2>
            <ul>
                <li><a href="#">Overview</a></li>
                <li><a href="#">Budget</a></li>
                <li><a href="#">Scheduler</a></li>
                <li><a href="#">Reports</a></li>
            </ul>
        </aside> --}}

        <main class="main-content">
            <h1>Dashboard</h1>

            <div class="widgets-container">
                <!-- Transactions Widget -->
                <div class="widget">
                    <h3>All Transactions</h3>
                    @if($transactions->isEmpty())
                        <p>No transactions available.</p>
                    @else
                        <ul>
                            @foreach ($transactions as $transaction)
                                <li>{{ $transaction->name }} - ${{ number_format($transaction->amount, 2) }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>

                <!-- Reports Widget -->
                <div class="widget">
                    <h3>Reports</h3>
                    <p>Income: ${{ number_format($totalIncome, 2) }}</p>
                    <p>Expenses: ${{ number_format($totalExpenses, 2) }}</p>
                </div>

                <!-- Budget Widget -->
                <div class="widget">
                    <h3>Budget</h3>
                    @if($budget)
                        <p>Budget Limit: ${{ number_format($budget->limit, 2) }}</p>
                        <p>Current Expenses: ${{ number_format($budget->current_expense, 2) }}</p>
                        <p>Status: {{ ucfirst($budget->status) }}</p>
                    @else
                        <p>No budget data available.</p>
                    @endif
                </div>
            </div>
        </main>
    </div>
@endsection
