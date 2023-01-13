<?php

namespace App\Repository;

use App\Models\TransactionHistory;
use Illuminate\Support\Facades\Auth;

class TransactionHistoryRepository
{
    private string $numberFrom;
    private string $numberTo;
    private string $comment;
    private string $sign;
    private float $amount;
    private string $currency;

    public function __construct(
        string $numberFrom,
        string $numberTo,
        string $comment,
        string $sign,
        float $amount,
        string $currency)
    {
        $this->numberFrom = $numberFrom;
        $this->numberTo = $numberTo;
        $this->comment = $comment;
        $this->sign = $sign;
        $this->amount = $amount;
        $this->currency = $currency;
    }

    public function insert(): void
    {
        $history = (new TransactionHistory())->fill([
            'numberFrom' => $this->numberFrom,
            'numberTo' => $this->numberTo,
            'comment' => $this->comment,
            'sign' => $this->sign,
            'amount' => $this->amount,
            'currency' => $this->currency,
        ]);
        $history->user()->associate(Auth::id());
        $history->save();
    }
}
