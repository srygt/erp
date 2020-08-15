<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class VergiNoRule implements Rule
{
    const LENGTH = 10;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        // https://github.com/aozisik/laravel-turkiye/blob/master/src/Rules/VergiKimlikNoRule.php
        if (strlen($value) !== self::LENGTH) {
            return false;
        }

        $sum = 0;

        for ($i = 0; $i < 9; $i++) {
            $mod = ($value[$i] + (9 - $i)) % 10;
            $pow = $mod * pow(2, (9 - $i)) % 9;
            $sum += ($mod !== 0 && $pow == 0) ? 9 : $pow;
        }

        $checksum = ($sum % 10 == 0) ? 0 : (10 - ($sum % 10));

        return $checksum == $value[9];
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return ':attribute alanında vergi numarası hatalı.';
    }
}
