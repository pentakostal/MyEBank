<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\UseerCoin;
use App\Services\CoinDataService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CoinMarketController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data = (new CoinDataService())->getCurrencies();

        $account = Account::where([
            ['user_id', Auth::id()],
            ['status', 'crypto']
        ])->get();

        $wallet = UseerCoin::where([
            ['user_id', Auth::id()]
        ])->get();

        return view('coinMarket', [
            'cryptoCurrencies' => $data,
            'account' => $account,
            'wallet' => $wallet
        ]);
    }

    public function buyCrypto(Request $request)
    {
        $coin = $request->validate([
            'symbol' => 'required',
            'amount' => 'required|numeric|gt:0',
            'buyPrice' => 'required|numeric|gt:0'
        ]);

        $symbol = $coin['symbol'];
        $amount = (float) $coin['amount'];
        $price = number_format((float) $coin['buyPrice'], 2, '.', '');

        $account = DB::table('accounts')
            ->where('user_id', Auth::id())
            ->where('status', 'crypto')
            ->get();

        $newBalance = (int) (($account[0]->balance / 100) - ($amount * $price)) * 100;


        DB::table('accounts')
            ->where('user_id', Auth::id())
            ->where('status', 'crypto')
            ->update(['balance' => $newBalance]);

        $userCoins = (new UseerCoin())->fill([
            'symbol' => $symbol,
            'amount' => $amount,
            'buy_price' => $price
        ]);

        $userCoins->user()->associate(Auth::id());
        $userCoins->save();

        return redirect()->route('coinMarket')->with('success', 'You buy a Crypto coins');
    }
}
