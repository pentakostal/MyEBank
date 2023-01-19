<?php

namespace App\Http\Controllers;

use App\Models\TransactionHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class TransactionHistoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $date = Carbon::now()->toDateString();
        $history = TransactionHistory::where('user_id', Auth::id())
            ->whereDate('created_at', $date)
            ->get();
        //echo "<pre>";
        //var_dump($date);
        return view('history', [
            'history' => $history
        ]);
    }

    public function search(Request $request)
    {
        $range = $request->validate([
            'start' => 'required',
            'end' => 'required'
        ]);

        //echo "<pre>";
        //var_dump($range["end"]);
        $history = TransactionHistory::where('user_id', Auth::id())
                ->whereDate('created_at', '>=', $range["start"])
                ->whereDate('created_at', '<=', $range["end"])
                ->get();

        return view('history', [
            'history' => $history
        ]);
    }
}
