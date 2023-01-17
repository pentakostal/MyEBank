<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class NumberIDnotSame implements Rule
{
    private string $numberFrom;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(string $numberFrom)
    {
        //
        $this->numberFrom = $numberFrom;
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
        $accountFrom = DB::table('accounts')->where('number', $this->numberFrom)->get();
        $accountTo = DB::table('accounts')->where('number', $value)->get();

        return $accountFrom[0]->user_id != $accountTo[0]->user_id;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Accounts must belong to different users';
    }
}
