@extends('layouts.app')

@section('content')
    @vite('resources/css/dashboard.css')

    <div class="dashboard-container">

        <main class="main-content">
            <h1>Dashboard</h1>

            <div class="widgets-container">
                <!-- Transactions Widget -->
                <div class="widget">
                    <h3>Daily Transactions</h3>
                    @if($dailyTransactionsCount == 0)
                        <p>No transactions available.</p>
                    @else
                        <p>{{ $dailyTransactionsCount }} transactions today</p>
                    @endif
                </div>

                <!-- Reports Widget -->
                <div class="widget">
                    <h3>Reports</h3>
                    <p>Weekly Income: Ksh.{{ number_format($totalIncome, 2) }}</p>
                    <p>Weekly Expenses: Ksh.{{ number_format($totalExpenses, 2) }}</p>
                </div>

                <!-- Budget Widget -->
                <div class="widget">
                    <h3>Budget</h3>
                    @if($budget)
                        <p>Monthly Budget Limit: Ksh.{{ number_format($budget->limit, 2) }}</p>
                        <p>Current Monthly Expenses: Ksh.{{ number_format($budget->current_expense, 2) }}</p>
                        <p>Status: {{ ucfirst($budget->status) }}</p>
                    @else
                        <p>No budget data available.</p>
                    @endif
                </div>

                <!-- Line Graph Widget (Financial Trends) -->
                <div class="widget">
                    <h3>Financial Trends</h3>
                    <canvas id="financialChart"></canvas>
                </div>

                <!-- Latest Transactions Widget -->
                <div class="widget">
                    <h3>Latest Transactions</h3>
                    @if($latestTransactions->isEmpty())
                        <p>No recent transactions.</p>
                    @else
                        <ul>
                            @foreach($latestTransactions as $transaction)
                                <li>
                                    <strong>{{ $transaction->description }}</strong> -
                                    Ksh.{{ number_format($transaction->amount, 2) }}
                                    <span class="{{ $transaction->type == 'income' ? 'text-success' : 'text-danger' }}">
                                        ({{ ucfirst($transaction->type) }})
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>

            {{-- <!-- Include Chart.js for the line graph -->
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                document.addEventListener("DOMContentLoaded", function () {
                    var ctx = document.getElementById('financialChart').getContext('2d');
                    var financialChart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: @json($chartLabels), // Dates
                            datasets: [
                                {
                                    label: 'Income',
                                    data: @json($incomeData), // Income values
                                    borderColor: 'green',
                                    fill: false
                                },
                                {
                                    label: 'Expenses',
                                    data: @json($expenseData), // Expense values
                                    borderColor: 'red',
                                    fill: false
                                }
                            ]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false
                        }
                    });
                });
            </script> --}}

        </main>
    </div>
@endsection
