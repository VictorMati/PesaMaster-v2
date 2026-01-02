@extends('layouts.app')
@vite('resources/css/dashboard.css')
@section('content')


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
                <div class="chart-widget">
                    <h3>Financial Trends</h3>
                    <canvas id="financialChart"></canvas>
                </div>

                <!-- Latest Transactions Widget -->
                <div class="transactions-widget">
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

           <!-- Include Chart.js -->
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns"></script>


            <script>
            document.addEventListener("DOMContentLoaded", function () {
                const ctx = document.getElementById('financialChart').getContext('2d');

                if (typeof Chart !== 'undefined') {

                    // Convert PHP data into JS arrays
                    const incomeData = @json($incomeData);
                    const expenseData = @json($expenseData);

                    // Combine all values to compute scale
                    const allValues = incomeData.concat(expenseData);

                    // Calculate dynamic min & max
                    const minValue = Math.min(...allValues);
                    const maxValue = Math.max(...allValues);

                    // Add padding so graph breathes
                    const padding = 2000;

                    new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: @json($chartLabels),
                            datasets: [
                                {
                                    label: 'Income',
                                    data: incomeData,
                                    borderColor: 'green',
                                    backgroundColor: 'rgba(0, 128, 0, 0.1)',
                                    tension: 0.3
                                },
                                {
                                    label: 'Expenses',
                                    data: expenseData,
                                    borderColor: 'red',
                                    backgroundColor: 'rgba(255, 0, 0, 0.1)',
                                    tension: 0.3
                                }
                            ]
                        },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false, // 🔥 KEY FIX

                        scales: {
                            x: {
                                type: 'time',
                                time: {
                                    unit: 'day',
                                    tooltipFormat: 'dd MMM yyyy',
                                    displayFormats: {
                                        day: 'dd MMM'
                                    }
                                },
                                title: {
                                    display: true,
                                    text: 'Date'
                                }
                            },

                            y: {
                                title: {
                                    display: true,
                                    text: 'Amount (KES)'
                                },

                                suggestedMin: Math.max(0, minValue - 3000),
                                suggestedMax: maxValue + 3000,

                                ticks: {
                                    stepSize: 5000,
                                    callback: value => 'KSh ' + value.toLocaleString()
                                }
                            }
                        },

                        plugins: {
                            legend: {
                                position: 'top'
                            },
                            tooltip: {
                                callbacks: {
                                    label: ctx =>
                                        `${ctx.dataset.label}: KSh ${ctx.parsed.y.toLocaleString()}`
                                }
                            }
                        }
                    }

                    });

                } else {
                    console.error('Chart.js is not loaded');
                }
            });
            </script>
        </main>
    </div>
@endsection
