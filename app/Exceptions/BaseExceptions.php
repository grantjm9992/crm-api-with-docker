<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class BaseExceptions extends Handler
{
    function __construct($code, $message) {
        return json_encode()
    }
}
