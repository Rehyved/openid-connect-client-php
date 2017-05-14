<?php

namespace Rehyved\openid\client\token\validation;


class IssuerChecker extends \Jose\Checker\IssuerChecker
{
    private $allowedIssuer;
    public function __construct($allowedIssuer)
    {
        $this->allowedIssuer = $allowedIssuer;
    }

    /**
     * @param string $issuer
     *
     * @return bool
     */
    protected function isIssuerAllowed($issuer)
    {
        return $issuer === $this->allowedIssuer;
    }
}