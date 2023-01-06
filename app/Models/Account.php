<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Account extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'status',
        'currency'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getCurrencySymbolAttribute(): string
    {
        if ($this->currency == "EUR") {
            return "€";
        }

        if ($this->currency == "JPY" || $this->currency == "CNY") {
            return "¥";
        }

        if ($this->currency == "BRL") {
            return "R$";
        }

        return "$";
    }
}
