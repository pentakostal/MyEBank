<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\UseerCoin;
use App\Rules\CryptoSellAmountDoesnExceed;
use App\Rules\IfCryptoSymbolInWallet;
use App\Services\CoinDataService;
use App\Services\CryptoBuyService;
use App\Services\CryptoSellService;
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
        ]);

        $symbol = $coin['symbol'];
        $amount = (float) $coin['amount'];
        $price = number_format((float) $coin['buyPrice'], 2, '.', '');

        (new CryptoBuyService($symbol, $amount, $price))->buyCrypto();

        return redirect()->route('coinMarket')->with('success', 'You buy a Crypto coins');
    }

    public function sellCrypto(Request $request)
    {
        $coin = $request->validate([
            'symbol' => 'required',
            'amountSell' => ['required', 'numeric', 'gt:0', new CryptoSellAmountDoesnExceed($request['symbol'])],
        ]);

        $symbol = $coin['symbol'];
        $amount = (float) $coin['amountSell'];

        (new CryptoSellService($symbol, $amount))->sellCrypto();

        return redirect()->route('coinMarket')->with('success', 'You sell a Crypto coins');
    }
}
