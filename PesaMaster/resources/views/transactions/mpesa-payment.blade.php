@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Confirm M-Pesa Payment</div>

                <div class="card-body">
                    <div class="alert alert-info" role="alert">
                        You will receive an STK push notification on your phone to complete this payment.
                    </div>

                    <div class="transaction-details mb-4">
                        <h5>Transaction Details</h5>
                        <p><strong>Amount:</strong> KES {{ number_format($amount, 2) }}</p>
                        <p><strong>Phone Number:</strong> {{ $phone }}</p>
                        <p><strong>Transaction Type:</strong> {{ ucfirst($transaction->type) }}</p>
                        @if($transaction->description)
                            <p><strong>Description:</strong> {{ $transaction->description }}</p>
                        @endif
                    </div>

                    <form action="{{ route('mpesa.stkPush') }}" method="POST">
                        @csrf
                        <input type="hidden" name="transaction_id" value="{{ $transaction->id }}">
                        <input type="hidden" name="phone" value="{{ $phone }}">
                        <input type="hidden" name="amount" value="{{ $amount }}">

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Send M-Pesa Payment Request</button>
                            <a href="{{ route('transactions.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
