<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class KeyCodeCorrect implements Rule
{
    private int $number;
    private int $userID;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($userID, int $number)
    {
        //
        $this->number = $number;
        $this->userID = $userID;
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
        $code = DB::table('key_cards')
            ->where('user_id', $this->userID)
            ->value($this->number);

        return $code == $value;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Incorrect key code';
    }
}
