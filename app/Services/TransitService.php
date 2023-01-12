<?php

namespace App\Services;

use App\Models\Account;
use Illuminate\Support\Facades\DB;

class TransitService
{
    private string $numberFrom;
    private string $numberTo;
    private float $amount;

    public function __construct(
        string $numberFrom,
        string $numberTo,
        float $amount
    )
    {
        $this->numberFrom = $numberFrom;
        $this->numberTo = $numberTo;
        $this->amount = $amount;
    }

    public function makeTransit(): void
    {
        $accountFrom = DB::table('accounts')->where('number', $this->numberFrom)->get();
        $accountTo = DB::table('accounts')->where('number', $this->numberTo)->get();

        $newBalanceFrom = null;
        $newBalanceTo = null;

        if ($accountFrom[0]->currency == $accountTo[0]->currency) {
            $newBalanceFrom = $accountFrom[0]->balance - $this->amount * 100;
            $newBalanceTo = $accountTo[0]->balance + $this->amount * 100;
        } elseif ($accountFrom[0]->currency == "EUR" && $accountTo[0]->currency != "EUR") {
            $ratio = (new CurrencyRatioService)->getRatio($accountTo[0]->currency);

            $newBalanceFrom = $accountFrom[0]->balance - $this->amount * 100;
            $newBalanceTo = $accountTo[0]->balance + ($this->amount * $ratio) * 100;
        } elseif ($accountFrom[0]->currency != "EUR" && $accountTo[0]->currency == "EUR") {
            $ratio = (new CurrencyRatioService)->getRatio($accountFrom[0]->currency);

            $newBalanceFrom = $accountFrom[0]->balance - $this->amount * 100;
            $newBalanceTo = $accountTo[0]->balance + ($this->amount / $ratio) * 100;
        } elseif ($accountFrom[0]->currency != "EUR" && $accountTo[0]->currency != "EUR") {
            $ratioFrom = (new CurrencyRatioService)->getRatio($accountFrom[0]->currency);
            $ratioTo = (new CurrencyRatioService)->getRatio($accountFrom[0]->currency);

            $newBalanceFrom = $accountFrom[0]->balance - $this->amount * 100;
            $newBalanceTo = $accountTo[0]->balance + (($this->amount / $ratioFrom) * $ratioTo) * 100;
        }

        Account::where('number', $this->numberFrom)->update(['balance' => $newBalanceFrom]);
        Account::where('number', $this->numberTo)->update(['balance' => $newBalanceTo]);
    }
}