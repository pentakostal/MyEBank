<?php

namespace App\Services;

use App\Models\Account;
use App\Repository\TransactionHistoryRepository;
use Illuminate\Support\Facades\DB;

class TransitService
{
    private string $numberFrom;
    private string $numberTo;
    private float $amount;
    private string $comment;
    private string $sign;
    private int $userId;

    public function __construct(
        string $numberFrom,
        string $numberTo,
        float $amount,
        string $comment,
        string $sign,
        int $userId
    )
    {
        $this->numberFrom = $numberFrom;
        $this->numberTo = $numberTo;
        $this->amount = $amount;
        $this->comment = $comment;
        $this->sign = $sign;
        $this->userId = $userId;
    }

    public function makeTransit(): void
    {
        $accountFrom = DB::table('accounts')->where('number', $this->numberFrom)->get();
        $accountTo = DB::table('accounts')->where('number', $this->numberTo)->get();

        $newBalanceFrom = null;
        $newBalanceTo = null;
        $addAmount = null;

        if ($accountFrom[0]->currency == $accountTo[0]->currency) {
            $newBalanceFrom = $accountFrom[0]->balance - $this->amount * 100;
            $newBalanceTo = $accountTo[0]->balance + $this->amount * 100;
        } elseif ($accountFrom[0]->currency == "EUR" && $accountTo[0]->currency != "EUR") {
            $ratio = (new CurrencyRatioService)->getRatio($accountTo[0]->currency);
            $addAmount = ($this->amount * $ratio) * 100;

            $newBalanceFrom = $accountFrom[0]->balance - $this->amount * 100;
            $newBalanceTo = $accountTo[0]->balance + $addAmount;
        } elseif ($accountFrom[0]->currency != "EUR" && $accountTo[0]->currency == "EUR") {
            $ratio = (new CurrencyRatioService)->getRatio($accountFrom[0]->currency);
            $addAmount = ($this->amount / $ratio) * 100;

            $newBalanceFrom = $accountFrom[0]->balance - $this->amount * 100;
            $newBalanceTo = $accountTo[0]->balance + $addAmount;
        } elseif ($accountFrom[0]->currency != "EUR" && $accountTo[0]->currency != "EUR") {
            $ratioFrom = (new CurrencyRatioService)->getRatio($accountFrom[0]->currency);
            $ratioTo = (new CurrencyRatioService)->getRatio($accountFrom[0]->currency);
            $addAmount = (($this->amount / $ratioFrom) * $ratioTo) * 100;

            $newBalanceFrom = $accountFrom[0]->balance - $this->amount * 100;
            $newBalanceTo = $accountTo[0]->balance + $addAmount;
        }

        if ($accountFrom[0]->user_id == $accountTo[0]->user_id) {
            (new TransactionHistoryRepository(
                $accountFrom[0]->user_id,
                $this->numberFrom,
                $this->numberTo,
                $this->comment,
                $this->sign,
                $this->amount,
                $accountFrom[0]->currency
            ))->insert();
        }

        if ($accountFrom[0]->user_id != $accountTo[0]->user_id) {
            (new TransactionHistoryRepository(
                $accountFrom[0]->user_id,
                $this->numberFrom,
                $this->numberTo,
                $this->comment,
                '-',
                $this->amount,
                $accountFrom[0]->currency
            ))->insert();

            (new TransactionHistoryRepository(
                $accountTo[0]->user_id,
                $this->numberTo,
                $this->numberFrom,
                $this->comment,
                '+',
                (float) $addAmount,
                $accountTo[0]->currency
            ))->insert();
        }

        Account::where('number', $this->numberFrom)->update(['balance' => $newBalanceFrom]);
        Account::where('number', $this->numberTo)->update(['balance' => $newBalanceTo]);
    }
}
