<?php

namespace Rehyved\openid\client\token;


use Jose\Loader;
use Jose\Object\JWKSetInterface;
use Jose\Object\JWSInterface;
use Rehyved\openid\client\jwk\JsonWebAlgorithms;
use Rehyved\openid\JwtClaimTypes;

class TokenValidator
{
    public static function parseAndValidate(string $token, JWKSetInterface $jwks, string $issuer, string $audience, $nonce = null, $jti = null): JWSInterface
    {
        $loader = new Loader();
        $jws = $loader->loadAndVerifySignatureUsingKeySet($token, $jwks, JsonWebAlgorithms::all());

        if ($jws->hasClaim(JwtClaimTypes::ISSUER)) {
            $issuerClaim = $jws->getClaim(JwtClaimTypes::ISSUER);
            if ($issuerClaim !== $issuer) {
                throw new TokenValidationException("The issuer in the token did not match: " . $issuerClaim);
            }
        } else {
            throw new TokenValidationException("The issuer claim '" . JwtClaimTypes::ISSUER . "' was not found in the token.");
        }

        if ($jws->hasClaim(JwtClaimTypes::AUDIENCE)) {
            $audienceClaim = $jws->getClaim(JwtClaimTypes::AUDIENCE);
            if ($audienceClaim !== $audience) {
                throw new TokenValidationException("The audience in the token did not match: " . $audienceClaim);
            }
        } else {
            throw new TokenValidationException("The audience claim '" . JwtClaimTypes::AUDIENCE . "' was not found in the token.");
        }

        if ($nonce !== null && $jws->hasClaim(JwtClaimTypes::NONCE)) {
            $nonceClaim = $jws->getClaim(JwtClaimTypes::NONCE);
            if ($nonceClaim !== $nonce) {
                throw new TokenValidationException("The audience in the token did not match: " . $nonceClaim);
            }
        } else if ($nonce !== null) {
            throw new TokenValidationException("The nonce claim '" . JwtClaimTypes::NONCE . "' was not found in the token.");
        }

        if ($jti !== null && $jws->hasClaim(JwtClaimTypes::JWT_ID)) {
            $jtiClaim = $jws->getClaim(JwtClaimTypes::JWT_ID);
            if ($jtiClaim !== $jti) {
                throw new TokenValidationException("The JWT ID in the token did not match: " . $jtiClaim);
            }
        } else if ($jti !== null) {
            throw new TokenValidationException("The JWT ID claim '" . JwtClaimTypes::JWT_ID . "' was not found in the token.");
        }

        return $jws;
    }
}