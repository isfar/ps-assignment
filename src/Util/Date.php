<?php

namespace App\Util;

use DateTime;
use Exception;

class Date
{
    /**
     * @param string $date Date in Y-m-d format
     */
    public static function isValid(string $date)
    {
        if (preg_match("/^(\d{4})-(\d{1,2})-(\d{1,2})$/", $date)) {
            try {
                new DateTime($date);
            } catch (Exception $e) {
                return false;
            }

            return true;
        }

        return false;
    }
}
