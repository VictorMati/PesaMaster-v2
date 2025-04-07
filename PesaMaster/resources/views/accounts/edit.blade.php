@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Account</h1>

    <form action="{{ route('accounts.update', $account->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Account Name:</label>
            <input type="text" id="name" name="name" class="form-control" value="{{ $account->name }}" required>
        </div>

        <div class="form-group">
            <label for="balance">Balance (Ksh):</label>
            <input type="number" id="balance" name="balance" class="form-control" value="{{ $account->balance }}" required>
        </div>

        <button type="submit" class="btn btn-success">Update Account</button>
        <a href="{{ route('accounts.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
