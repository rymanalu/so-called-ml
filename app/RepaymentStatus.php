<?php

namespace App;

final class RepaymentStatus
{
    public static function isDuly($code)
    {
        return $code == -1 || $code == 0;
    }

    public static function isLate($code)
    {
        return !static::isDuly($code);
    }
}
