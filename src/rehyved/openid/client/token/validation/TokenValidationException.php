<?php

namespace Rehyved\openid\client\token;


class TokenValidationException extends \Exception
{
    public function __construct($message)
    {
        parent::__construct($message);
    }
}