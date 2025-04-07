@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create Budget</h1>

    <form action="{{ route('budgets.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="period" class="form-label">Category</label>
            <input type="text" id="category" name="category" class="form-control" placeholder="e.g utilities, groceries and food stuffs" required>
        </div>

        <div class="mb-3">
            <label for="period" class="form-label">Budget Period (YYYY-MM)</label>
            <input type="month" id="period" name="period" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="limit" class="form-label">Budget Limit (Ksh.)</label>
            <input type="number" id="limit" name="limit" class="form-control" step="0.01" required>
        </div>

        <button type="submit" class="btn btn-primary">Save Budget</button>
        <a href="{{ route('budgets.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
