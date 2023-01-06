<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
}
