@extends('layouts.admin_layout')

@section('content')
<div class="container-fluid mt-4">
    <h2 class="mb-4">Admin Dashboard</h2>

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card p-3 shadow-sm">
                <h5>Total Users</h5>
                <h2>{{ $totalUsers }}</h2>
            </div>
        </div>
        {{-- Add more dashboard cards here --}}
    </div>

    <div class="row">
        <div class="col-md-6">
            <h4>Recent Users</h4>
            <ul class="list-group">
                @foreach ($recentUsers as $user)
                    <li class="list-group-item">
                        {{ $user->name }} ({{ $user->email }}) - Joined {{ $user->created_at->diffForHumans() }}
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="col-md-6">
            <h4>Recent System Logs</h4>
            @if (isset($recentLogs))
                <ul class="list-group">
                    @foreach ($recentLogs as $log)
                        <li class="list-group-item">
                            {{ $log->action ?? 'Log Entry' }} @ {{ \Carbon\Carbon::parse($log->created_at)->diffForHumans() }}
                        </li>
                    @endforeach
                </ul>
            @else
                <p>No logs to display.</p>
            @endif
        </div>
    </div>
</div>
@endsection
