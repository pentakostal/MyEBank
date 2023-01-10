<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Services\CurrencyRatioService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use SimpleXMLElement;

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
            'status' => 'in:debit,credit'
        ]);

        $account = (new Account())->fill([
            'number' => 'LV' . rand(1000000000, 9999999999),
            'balance' => 0,
            'currency' => $validated['currency'],
            'status' => $validated['status'],
        ]);
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

        return redirect()->route('home');
    }

    public function transitInternal(Request $request)
    {
        $transit = $request->validate([
            'fromAccount' => 'required',
            'toAccount' => 'required',
            'transactionAmount' => 'required|numeric|gt:0',
        ]);

        $accountFrom = DB::table('accounts')->where('number', $transit['fromAccount'])->get();
        $accountTo = DB::table('accounts')->where('number', $transit['toAccount'])->get();

        $amount = $transit['transactionAmount'] * 100;

        $balanceFrom = $accountFrom[0]->balance;
        $balanceTo = $accountTo[0]->balance;

        if ($accountFrom[0]->currency == $accountTo[0]->currency) {
            $newBalanceFrom = $balanceFrom - $amount;
            $newBalanceTo = $balanceTo + $amount;

            Account::where('number', $transit['fromAccount'])->update(['balance' => $newBalanceFrom]);
            Account::where('number', $transit['toAccount'])->update(['balance' => $newBalanceTo]);

            return redirect()->route('home');
        }

        if ($accountFrom[0]->currency == "EUR" && $accountTo[0]->currency != "EUR") {
            $ratio = (new CurrencyRatioService)->getRatio($accountTo[0]->currency) / 100;

            $newBalanceFrom = $balanceFrom - $amount;
            $newBalanceTo = $balanceTo + ($amount * $ratio);

            Account::where('number', $transit['fromAccount'])->update(['balance' => $newBalanceFrom]);
            Account::where('number', $transit['toAccount'])->update(['balance' => $newBalanceTo]);

            return redirect()->route('home');
        }

        if ($accountFrom[0]->currency != "EUR" && $accountTo[0]->currency == "EUR") {
            $ratio = (new CurrencyRatioService)->getRatio($accountFrom[0]->currency) / 100;

            $newBalanceFrom = $balanceFrom - $amount;
            $newBalanceTo = $balanceTo + ($amount / $ratio);

            Account::where('number', $transit['fromAccount'])->update(['balance' => $newBalanceFrom]);
            Account::where('number', $transit['toAccount'])->update(['balance' => $newBalanceTo]);

            return redirect()->route('home');
        }

        if ($accountFrom[0]->currency != "EUR" && $accountTo[0]->currency != "EUR") {
            $ratioFrom = (new CurrencyRatioService)->getRatio($accountFrom[0]->currency) / 100;
            $ratioTo = (new CurrencyRatioService)->getRatio($accountFrom[0]->currency) / 100;

            $newBalanceFrom = $balanceFrom - $amount;
            $newBalanceTo = $balanceTo + (($amount / $ratioFrom) * $ratioTo);

            Account::where('number', $transit['fromAccount'])->update(['balance' => $newBalanceFrom]);
            Account::where('number', $transit['toAccount'])->update(['balance' => $newBalanceTo]);

            return redirect()->route('home');
        }
    }
}
