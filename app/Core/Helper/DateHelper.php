<?php

namespace App\Core\Helper;

use Carbon\Carbon;

class DateHelper
{
    /**
     * @param $date
     * @param string $format
     * @return string
     */
    public static function format($date, string $format = 'Y-m-d'): string {
        return Carbon::parse($date)->format($format);
    }

    /**
     * @param string $format
     * @return string
     */
    public static function now( string $format = 'Y-m-d H:i:s'): string {
        return Carbon::now()->format($format);
    }
}