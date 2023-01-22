<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class IfCryptoSymbolInWallet implements Rule
{
    private string $userID;
    private string $symbol;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(string $userID, string $symbol)
    {
        $this->userID = $userID;
        $this->symbol = $symbol;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        //
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The validation error message.';
    }

    public function exists()
    {
        return DB::table('useer_coins')
            ->where('user_id', $this->userID)
            ->where('symbol', $this->symbol)
            ->exists();
    }
}
