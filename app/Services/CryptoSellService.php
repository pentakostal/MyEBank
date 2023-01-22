<?php

namespace App\Services;

use App\Repository\TransactionHistoryRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CryptoSellService
{
    private string $symbol;
    private float $amount;

    public function __construct(string $symbol, float $amount)
    {
        $this->symbol = $symbol;
        $this->amount = $amount;
    }

    public function sellCrypto():void
    {
        $price = (new CoinDataService())->getPrice($this->symbol);

        $account = DB::table('accounts')
            ->where('user_id', Auth::id())
            ->where('status', 'crypto')
            ->get();

        $newBalance = (int) (($account[0]->balance / 100) + ($this->amount * $price)) * 100;

        DB::table('accounts')
            ->where('user_id', Auth::id())
            ->where('status', 'crypto')
            ->update(['balance' => $newBalance]);

        $userCoinWallet = DB::table('useer_coins')
            ->where('user_id', Auth::id())
            ->where('symbol', $this->symbol)
            ->get();

        $newAmount = $userCoinWallet[0]->amount - $this->amount;

        if ($newAmount == 0) {
            DB::table('useer_coins')
                ->where('user_id', Auth::id())
                ->where('symbol', $this->symbol)
                ->delete();
        } else {
            DB::table('useer_coins')
                ->where('user_id', Auth::id())
                ->where('symbol', $this->symbol)
                ->update(['amount' => $newAmount]);
        }

        (new TransactionHistoryRepository(
            Auth::id(),
            '',
            $account[0]->number,
            'crypto coin sell /' . $this->symbol,
            '+',
            ($this->amount * $price),
            'EUR',
        ))->insert();

        (new TransactionHistoryRepository(
            Auth::id(),
            '',
            '',
            'crypto coin sell /' . $this->symbol,
            '-',
            $this->amount,
            $this->symbol,
        ))->insert();
    }
}
