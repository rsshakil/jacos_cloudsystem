<?php

namespace App\Exceptions;

use Throwable;
use Exception;

class JcsException extends Exception
{
    public function __construct($message, $code = 1, Throwable $previous = null)
    {
        parent::__construct($message, $code);
    }
}
