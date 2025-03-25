
    @extends('layouts.app')

    @section('content')
        <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

        <div class="dashboard-container">
            <aside class="sidebar">
                <h2>Menu</h2>
                <ul>
                    <li><a href="#">Overview</a></li>
                    <li><a href="#">Budget</a></li>
                    <li><a href="#">Scheduler</a></li>
                    <li><a href="#">Reports</a></li>
                </ul>
            </aside>

            <main class="main-content">
                <h1>Dashboard</h1>
                <div class="widgets-container">
                    <div class="widget">
                        <h3>All Transactions</h3>
                        <ul>
                            @foreach ($transactions as $transaction)
                                <li>{{ $transaction->name }} - ${{ $transaction->amount }}</li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="widget">
                        <h3>Reports</h3>
                        <p>Income: ${{ $totalIncome }}</p>
                        <p>Expenses: ${{ $totalExpenses }}</p>
                    </div>

                    <div class="widget">
                        <h3>Budget</h3>
                        <p>Income: ${{ $budget->income }}</p>
                        <p>Expenses: ${{ $budget->expenses }}</p>
                    </div>
                </div>
            </main>
        </div>
    @endsection
