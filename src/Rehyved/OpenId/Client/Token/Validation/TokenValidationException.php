<?php

namespace Rehyved\OpenId\Client\Token\Validation;


class TokenValidationException extends \Exception
{
    public function __construct($message, int $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}