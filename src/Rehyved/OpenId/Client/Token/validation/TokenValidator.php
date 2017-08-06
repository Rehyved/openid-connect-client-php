<?php

namespace Rehyved\OpenId\Client\Token\validation;


use Jose\Checker\AudienceChecker;
use Jose\Factory\CheckerManagerFactory;
use Jose\Loader;
use Jose\Object\JWKSetInterface;
use Jose\Object\JWSInterface;
use Rehyved\OpenId\Client\Jwk\JsonWebAlgorithms;

class TokenValidator
{
    public static function parseAndValidate(string $token, JWKSetInterface $jwks, string $issuer, string $audience, $nonce = null, $jti = null): JWSInterface
    {
        try {

            // Verify signature
            $loader = new Loader();
            $jws = $loader->loadAndVerifySignatureUsingKeySet($token, $jwks, JsonWebAlgorithms::all());


            // Check claims
            $claimCheckerList = array(
                new IssuerChecker($issuer),
                new AudienceChecker($audience),
                'exp',
                new LenientNotBeforeChecker(),
                new NonceChecker($nonce),
                new JtiChecker($jti)
            );
            $claimChecker = CheckerManagerFactory::createClaimCheckerManager($claimCheckerList);
            $claimChecker->checkJWS($jws, 0);

            return $jws;
        } catch (\Exception $e) {
            throw new TokenValidationException("Token not valid.", 0, $e);
        }
    }
}