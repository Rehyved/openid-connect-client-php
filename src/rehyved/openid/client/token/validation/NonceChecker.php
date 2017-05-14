<?php

namespace Rehyved\openid\client\token\validation;


use Jose\Checker\ClaimCheckerInterface;
use Jose\Object\JWTInterface;
use Rehyved\openid\JwtClaimTypes;

class NonceChecker implements ClaimCheckerInterface
{

    private $expectedNonce;
    public function __construct($expectedNonce)
    {
        $this->expectedNonce = $expectedNonce;
    }


    /**
     * @param \Jose\Object\JWTInterface $jwt
     * @return \string[]
     * @throws TokenValidationException
     */
    public function checkClaim(JWTInterface $jwt)
    {
        if (!$jwt->hasClaim(JwtClaimTypes::NONCE)) {
            throw new TokenValidationException("Nonce claim was expected but not found in token.");
        }

        $nonce = $jwt->getClaim(JwtClaimTypes::NONCE);
        if ($this->expectedNonce !== $nonce) {
            throw new TokenValidationException("Nonce did not match expected value.");
        }

        return [JwtClaimTypes::NONCE];
    }
}