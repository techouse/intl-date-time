<?php

namespace Techouse\IntlDateTime;

use Exception;
use Throwable;

class LocaleNotSupportedException extends Exception
{
    public function __construct(string $message = 'Locale not supported by MomentJS', int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}