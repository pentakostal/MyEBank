<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Repository\TransactionHistoryRepository;
use App\Rules\KeyCodeCorrect;
use App\Rules\NumberIDisSame;
use App\Services\TransitService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AccountFunctions extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('addAccount');
    }

    protected function addAccount(Request $request)
    {
        $validated = $request->validate([
            'currency' => 'in:EUR,USD,JPY,CNY,BRL',
            'status' => 'in:debit,credit,crypto'
        ]);

        $account = null;
        if ($validated['status'] == 'credit') {
            $account = (new Account())->fill([
                'number' => 'LV' . rand(1000000000, 9999999999),
                'balance' => 250000,
                'currency' => 'EUR',
                'status' => $validated['status'],
            ]);
        } elseif ($validated['status'] == 'crypto') {
            $account = (new Account())->fill([
                'number' => 'LV' . rand(1000000000, 9999999999),
                'balance' => 0,
                'currency' => 'EUR',
                'status' => $validated['status'],
            ]);
        } else {
            $account = (new Account())->fill([
                'number' => 'LV' . rand(1000000000, 9999999999),
                'balance' => 0,
                'currency' => $validated['currency'],
                'status' => $validated['status'],
            ]);
        }

        $account->user()->associate(Auth::id());
        $account->save();

        return redirect()->route('home');
    }

    public function deleteAccount(Request $request)
    {
        $number = $request->validate([
            'number' => 'required'
        ]);

        Account::where('number', $number)->delete();

        return redirect()->route('home');
    }

    public function addMoney(Request $request)
    {
        $number = $request->validate([
            'number' => 'required',
            'balance' => 'required',
            'newBalance' => 'required|numeric|gt:0'
        ]);

        $newBalance = $number['newBalance'] * 100 + $number['balance'];

        Account::where('number', $number['number'])->update(['balance' => $newBalance]);

        (new TransactionHistoryRepository(
            Auth::id(),
            '',
            $number['number'],
            'add money to account',
            '+',
            $number['newBalance'],
            ''
        ))->insert();

        return redirect()->route('home');
    }

    public function transitInternal(Request $request)
    {
        $transit = $request->validate([
            'fromAccount' => 'required',
            'toAccount' => ['required', 'different:fromAccount', new NumberIDisSame($request['fromAccount'])],
            'transactionAmount' => 'required|numeric|gt:0',
            'keyCodeNumber' => 'required',
            'keyCode' => ['required', new KeyCodeCorrect(Auth::id(), (int) $request['keyCodeNumber'])]
        ]);

        (new TransitService(
            $transit['fromAccount'],
            $transit['toAccount'],
            $transit['transactionAmount'],
            'internal transaction',
            '',
            Auth::id()
        ))->makeTransit();

        return redirect()->route('home')->with('success', 'Transaction successful');
    }
}
