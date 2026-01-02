
@extends('layouts.app')
@vite('resources/css/transaction.css')
@section('content')
    <div class="container">
        <h1>Add New Transaction</h1>

        <form action="{{ route('transactions.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="amount" class="form-label">Amount (Ksh)</label>
                <input type="number" name="amount" id="amount" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="type" class="form-label">Transaction Type</label>
                <select name="type" id="type" class="form-control" required>
                    <option value="deposit">Deposit</option>
                    <option value="payment">Payment</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="payment_method" class="form-label">Payment Method</label>
                <select name="payment_method" id="payment_method" class="form-control" required>
                    <option value="cash">Cash</option>
                    <option value="mpesa">Mpesa</option>
                </select>
            </div>

            <div id="mpesaDetails" class="d-none">
                <div class="mb-3">
                    <label for="phone_number" class="form-label">Customer's Phone Number</label>
                    <input
                        type="tel"
                        name="phone_number"
                        id="phone_number"
                        class="form-control"
                        required
                        pattern="^2541\d{8}$"
                        placeholder="e.g. 254712345678"
                        title="Enter a valid Kenyan phone number in the format 2541XXXXXXXX">
                </div>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <input type="text" name="description" id="description" class="form-control" placeholder="Optional">
            </div>

            <button type="submit" class="btn btn-primary">Add</button>
        </form>
    </div>

    <script>
        // Show/Hide M-Pesa details based on payment method selection
        document.getElementById('payment_method').addEventListener('change', function() {
            var paymentMethod = this.value;
            if (paymentMethod === 'mpesa') {
                document.getElementById('mpesaDetails').classList.remove('d-none');
            } else {
                document.getElementById('mpesaDetails').classList.add('d-none');
            }
        });
    </script>
@endsection
