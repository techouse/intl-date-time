<?php

namespace Techouse\IntlDateTime;

use Exception;
use Throwable;

class TimeFormatNotSupportedException extends Exception
{
    public function __construct(string $message = 'Time format not supported by MomentJS', int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}