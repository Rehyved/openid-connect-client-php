<?php

namespace Rehyved\openid\client\token\validation;


class TokenValidationException extends \Exception
{
    public function __construct($message, int $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}