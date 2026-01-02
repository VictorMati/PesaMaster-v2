<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Report;
use App\Models\Account;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');

        $transactions = Transaction::where('description', 'like', "%$query%")->get();
        $accounts = Account::where('name', 'like', "%$query%")->get();
        $reports = Report::where('type', 'like', "%$query%")->get();

        return view('partials.search-results', compact('transactions', 'accounts', 'reports'));
    }

}
