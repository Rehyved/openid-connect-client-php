<?php

namespace Rehyved\openid\client\token\validation;


use Assert\Assertion;
use Jose\Checker\ClaimCheckerInterface;
use Jose\Object\JWTInterface;

class LenientNotBeforeChecker implements ClaimCheckerInterface
{

    const DEFAULT_LENIENT_SECONDS = 60;

    private $lenientSeconds;

    public function __construct($lenientSeconds = LenientNotBeforeChecker::DEFAULT_LENIENT_SECONDS)
    {
        $this->lenientSeconds = $lenientSeconds;
    }

    /**
     * @param \Jose\Object\JWTInterface $jwt
     *
     * @throws \InvalidArgumentException
     *
     * @return string[]
     */
    public function checkClaim(JWTInterface $jwt)
    {
        if (!$jwt->hasClaim('nbf')) {
            return [];
        }
        $nbf = (int)$jwt->getClaim('nbf');
        Assertion::lessOrEqualThan($nbf, time() + $this->lenientSeconds, 'The JWT can not be used yet.');
        return ['nbf'];
    }
}