<?php

namespace Rehyved\openid\client\token\validation;


class TokenValidationException extends \Exception
{
    public function __construct($message, \Throwable $previous)
    {
        parent::__construct($message, 0, $previous);
    }
}