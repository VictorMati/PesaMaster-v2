@if($transactions->isEmpty() && $accounts->isEmpty() && $reports->isEmpty())
    <p>No results found.</p>
@else
    @if($transactions->isNotEmpty())
        <h5>Transactions</h5>
        <ul>
            @foreach($transactions as $txn)
                <li>{{ $txn->description }} - KES {{ $txn->amount }}</li>
            @endforeach
        </ul>
    @endif

    @if($accounts->isNotEmpty())
        <h5>Accounts</h5>
        <ul>
            @foreach($accounts as $acc)
                <li>{{ $acc->name }}</li>
            @endforeach
        </ul>
    @endif

    @if($reports->isNotEmpty())
        <h5>Reports</h5>
        <ul>
            @foreach($reports as $report)
                <li>{{ $report->title }}</li>
            @endforeach
        </ul>
    @endif
@endif
