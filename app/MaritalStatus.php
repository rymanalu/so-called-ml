<?php

namespace App;

final class MaritalStatus
{
    const MARRIED = 1;
    const SINGLE = 2;
    const OTHERS = 3;

    public static function all()
    {
        return [
            static::MARRIED => 'Married',
            static::OTHERS => 'Others',
            static::SINGLE => 'Single',
        ];
    }

    public static function get($code)
    {
        $all = static::all();

        if (array_key_exists($code, $all)) {
            return $all[$code];
        }

        return static::OTHERS;
    }
}
