<?php

namespace Rehyved\openid\client\token;


use Jose\Checker\AudienceChecker;
use Jose\Loader;
use Jose\Object\JWKSetInterface;
use Jose\Object\JWSInterface;
use Rehyved\openid\client\jwk\JsonWebAlgorithms;
use Rehyved\openid\client\token\validation\IssuerChecker;
use Rehyved\openid\client\token\validation\JtiChecker;
use Rehyved\openid\client\token\validation\NonceChecker;

class TokenValidator
{
    public static function parseAndValidate(string $token, JWKSetInterface $jwks, string $issuer, string $audience, $nonce = null, $jti = null): JWSInterface
    {
        $loader = new Loader();
        $jws = $loader->loadAndVerifySignatureUsingKeySet($token, $jwks, JsonWebAlgorithms::all());
        $jws = $loader->loadAndDecryptUsingKeySet($token, $jwks, JsonWebAlgorithms::all(), JsonWebAlgorithms::all());
        $claimCheckerList = array(
            new IssuerChecker($issuer),
            new AudienceChecker($audience),
            'exp',
            'iat',
            'nbf',
            new NonceChecker($nonce),
            new JtiChecker($jti)
        );


        var_dump($jws->getPayload());
        return $jws;
    }
}