<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransactionHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'comment',
        'sign',
        'amount',
        'currency'
    ];

    public function history(): BelongsTo
    {
        return $this->belongsTo(TransactionHistory::class);
    }
}