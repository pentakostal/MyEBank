<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransactionHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'numberFrom',
        'numberTo',
        'comment',
        'sign',
        'amount',
        'currency'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
