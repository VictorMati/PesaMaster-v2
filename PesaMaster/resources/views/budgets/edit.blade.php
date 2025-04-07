@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Budget</h1>

    <form action="{{ route('budgets.update', $budget->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="period" class="form-label">Budget Period (YYYY-MM)</label>
            <input type="month" id="period" name="period" class="form-control" value="{{ $budget->period }}" required>
        </div>

        <div class="mb-3">
            <label for="limit" class="form-label">Budget Limit (Ksh.)</label>
            <input type="number" id="limit" name="limit" class="form-control" step="0.01" value="{{ $budget->limit }}" required>
        </div>

        <button type="submit" class="btn btn-success">Update Budget</button>
        <a href="{{ route('budgets.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
