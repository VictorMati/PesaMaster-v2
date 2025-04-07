@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Add New Account</h1>

    <form action="{{ route('accounts.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Account Name:</label>
            <input type="text" id="name" name="name" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="balance">Initial Balance (Ksh):</label>
            <input type="number" id="balance" name="balance" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">Save Account</button>
        <a href="{{ route('accounts.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
