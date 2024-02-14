<?php

namespace App\Exception;

use RuntimeException;
use Throwable;

class RequestBodyConvertException extends RuntimeException
{
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct('error while unmarshalling request body', 0, $previous);
    }
}