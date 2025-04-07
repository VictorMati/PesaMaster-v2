@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Budgets</h1>

    <a href="{{ route('budgets.create') }}" class="btn btn-primary">Create Budget</a>
    <br><br>
    <table class="table mt-3">
        <thead>
            <tr>
                <th>#</th>
                <th>Period</th>
                <th>Limit (Ksh.)</th>
                <th>Current Expense</th>
                <th>Status</th>
                <th>Actions</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($budgets as $budget)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $budget->period }}</td>
                    <td>{{ number_format($budget->limit, 2) }}</td>
                    <td>{{ number_format($budget->current_expense, 2) }}</td>
                    <td>{{ ucfirst($budget->status) }}</td>
                    <td><a href="{{ route('budgets.show', $budget->id) }}" class="btn btn-info btn-sm">View</a>
                        <a href="{{ route('budgets.edit', $budget->id) }}" class="btn btn-warning btn-sm">Edit</a></td>
                    <td>
                        <form action="{{ route('budgets.destroy', $budget->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
