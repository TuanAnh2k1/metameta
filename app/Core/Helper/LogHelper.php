<?php

namespace App\Core\Helper;

use Illuminate\Support\Facades\Log;

class LogHelper
{
    public static function Log($msg, $exception = null) {
        Log::error(
            $msg,
            [
                'line' => __LINE__,
                'method' => __METHOD__,
                'error_message' => $exception ? $exception->getMessage() : $msg,
            ]
        );
    }
}