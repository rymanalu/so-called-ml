<?php

namespace App;

class RepaymentStatus
{
    public static function isDuly($code)
    {
        return $code == -1;
    }

    public static function isLate($code)
    {
        return ! static::isDuly($code);
    }

    public static function numberOfMonthsDelay($code)
    {
        if (static::isLate($code)) {
            return abs($code);
        }

        return 0;
    }
}
