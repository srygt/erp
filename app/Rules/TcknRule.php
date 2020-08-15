<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class TcknRule implements Rule
{
    const LENGTH = 11;
    const DISALLOWED = [
        '11111111110',
        '22222222220',
        '33333333330',
        '44444444440',
        '55555555550',
        '66666666660',
        '77777777770',
        '88888888880',
        '99999999990',
    ];

    public function passes($attribute, $value)
    {
        // https://github.com/aozisik/laravel-turkiye/blob/master/src/Rules/TcKimlikNoRule.php
        $value = strval($value);

        if (strlen($value) != self::LENGTH || $value[0] === '0' || in_array($value, self::DISALLOWED)) {
            return false;
        }

        return $this->firstCheck($value) && $this->secondCheck($value);
    }

    public function message()
    {
        return ':attribute alanında TC Kimlik numarası hatalı.';
    }

    protected function firstCheck($value)
    {
        $a = 0;
        $b = 0;
        for ($i = 0;$i < 9;$i = $i + 2) {
            $a = $a + $value[$i];
        }
        for ($i = 1;$i < 9;$i = $i + 2) {
            $b = $b + $value[$i];
        }
        return ($a * 7 - $b) % 10 == $value[9];
    }

    protected function secondCheck($value)
    {
        $c = 0;
        for ($i = 0;$i < 10;$i = $i + 1) {
            $c = $c + $value[$i];
        }
        return $c % 10 == $value[10];
    }
}
