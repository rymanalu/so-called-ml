<?php

namespace App;

/**
 * Codes for the representation of human sexes (ISO/IEC 5218).
 */
final class Sex
{
    const NOT_KNOWN = 0;
    const MALE = 1;
    const FEMALE = 2;
    const NOT_APPLICABLE = 9;

    public static function all()
    {
        return [
            static::NOT_KNOWN => 'Not Known',
            static::MALE => 'Male',
            static::FEMALE => 'Female',
            static::NOT_APPLICABLE => 'Not Applicable',
        ];
    }

    public static function get($code)
    {
        $all = static::all();

        if (array_key_exists($code, $all)) {
            return $all[$code];
        }

        return '';
    }
}
