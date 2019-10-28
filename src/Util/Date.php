<?php

namespace App\Util;

class Date
{
    const MIN_YEAR  = 1800;
    const MAX_YEAR  = 2200;
    const MIN_MONTH = 1;
    const MAX_MONTH = 12;
    const MIN_DAY   = 1;
    const MAX_DAY   = 31;

    /**
     * @param string $date Date in Y-m-d format
     */
    public static function isValid(string $date)
    {
        if (preg_match("/^(\d{4})-(\d{1,2})-(\d{1,2})$/", $date, $matches)) {
            if (($matches[1] >= self::MIN_YEAR && $matches[1] <= self::MAX_YEAR)
                && ($matches[2] >= self::MIN_MONTH && $matches[2] <= self::MAX_MONTH)
                && ($matches[3] >= self::MIN_DAY && $matches[3] <= self::MAX_DAY)
            ) {
                return true;
            }
        }

        return false;
    }
}
