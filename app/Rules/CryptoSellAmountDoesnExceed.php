<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CryptoSellAmountDoesnExceed implements Rule
{
    private string $symbol;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(string $symbol)
    {
        //
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
        $userCoinWallet = DB::table('useer_coins')
            ->where('user_id', Auth::id())
            ->where('symbol', $this->symbol)
            ->get();

        return $userCoinWallet[0]->amount > $value;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Wrong amount';
    }
}
