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
    private int $userId;

    public function __construct(
        int $userId,
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
        $this->amount = $amount * 100;
        $this->currency = $currency;
        $this->userId = $userId;
    }

    public function insert(): void
    {
        $history = (new TransactionHistory())->fill([
            'user_id' => $this->userId,
            'numberFrom' => $this->numberFrom,
            'numberTo' => $this->numberTo,
            'comment' => $this->comment,
            'sign' => $this->sign,
            'amount' => $this->amount,
            'currency' => $this->currency,
        ]);

        $history->save();
    }
}
