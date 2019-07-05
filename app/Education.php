<?php

namespace App;

final class Education
{
    const GRADUATE_SCHOOL = 1;
    const UNIVERSITY = 2;
    const HIGH_SCHOOL = 3;

    public static function all()
    {
        return [
            static::GRADUATE_SCHOOL => 'Graduate School',
            static::HIGH_SCHOOL => 'High School',
            static::UNIVERSITY => 'University',
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
