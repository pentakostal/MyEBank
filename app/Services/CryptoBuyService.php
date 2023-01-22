<?php

namespace App\Services;

use App\Models\UseerCoin;
use App\Repository\TransactionHistoryRepository;
use App\Rules\IfCryptoSymbolInWallet;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CryptoBuyService
{
    private string $symbol;
    private float $amount;
    private float $price;

    public function __construct(string $symbol, float $amount, float $price)
    {
        $this->symbol = $symbol;
        $this->amount = $amount;
        $this->price = $price;
    }

    public function buyCrypto():void
    {
        $account = DB::table('accounts')
            ->where('user_id', Auth::id())
            ->where('status', 'crypto')
            ->get();

        $newBalance = (int) (($account[0]->balance / 100) - ($this->amount * $this->price)) * 100;


        DB::table('accounts')
            ->where('user_id', Auth::id())
            ->where('status', 'crypto')
            ->update(['balance' => $newBalance]);

        echo "<pre>";

        if ((new IfCryptoSymbolInWallet(Auth::id(), $this->symbol))->exists()) {
            $oldAmount = DB::table('useer_coins')
                ->where('user_id', Auth::id())
                ->where('symbol', $this->symbol)
                ->get();

            DB::table('useer_coins')
                ->where('user_id', Auth::id())
                ->where('symbol', $this->symbol)
                ->update(['amount' => $oldAmount[0]->amount + $this->amount]);
        } else {
            $userCoins = (new UseerCoin())->fill([
                'symbol' => $this->symbol,
                'amount' => $this->amount,
                'buy_price' => $this->price
            ]);

            $userCoins->user()->associate(Auth::id());
            $userCoins->save();
        }

        (new TransactionHistoryRepository(
            Auth::id(),
            '',
            $account[0]->number,
            'crypto coin buy /' . $this->symbol,
            '-',
            ($this->amount * $this->price),
            'EUR',
        ))->insert();

        (new TransactionHistoryRepository(
            Auth::id(),
            $account[0]->number,
            '',
            'crypto coin buy /' . $this->symbol,
            '+',
            $this->amount,
            $this->symbol,
        ))->insert();
    }
}
