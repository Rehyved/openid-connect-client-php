<?php

namespace Rehyved\openid\client\token;


use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer\Rsa\Sha256;
use Lcobucci\JWT\Signer\Rsa\Sha384;
use Lcobucci\JWT\Signer\Rsa\Sha512;
use Lcobucci\JWT\Token;
use Lcobucci\JWT\ValidationData;
use phpseclib\Crypt\RSA;
use phpseclib\Math\BigInteger;
use Rehyved\openid\client\jwk\JsonWebKey;
use Rehyved\openid\client\jwk\JsonWebKeySet;

class TokenValidator
{
    public static function parseAndValidate(string $token, JsonWebKeySet $jwks, string $issuer, string $audience, $nonce = null, $jti = null): Token
    {
        $token = (new Parser())->parse($token);

        $jwk = TokenValidator::determineJwk($jwks, $token->getHeader("kid"));

        $signer = TokenValidator::determineSigner($token->getHeader("alg"));

        $key = TokenValidator::buildPublicKey($jwk);

        $token->verify($signer, $key);

        $validationData = new ValidationData();
        $validationData->setIssuer($issuer);
        $validationData->setAudience($audience);
        $validationData->setId($jti);

        if ($token->getClaim("nonce") !== $nonce) {
            throw new TokenValidationException("The nonce in the received token did not match.");
        }

        if ($token->validate($validationData) === false) {
            throw new TokenValidationException("The token could not be validated. Issuer, audience or id did not match.");
        };


        return $token;
    }

    private static function determineJwk(JsonWebKeySet $jwks, $kid)
    {

        // TODO: expand selection criteria: https://github.com/Spomky-Labs/jose/blob/master/src/Object/BaseJWKSet.php#L169
        foreach ($jwks->getKeys() as $jwk) {
            if ($jwk->getKid() === $kid) {
                return $jwk;
            }
        }
        throw new TokenValidationException("Could not find JWK for token kid: " . $kid);
    }

    private static function determineSigner(string $alg)
    {
        switch ($alg) {
            case "HS256":
                return new \Lcobucci\JWT\Signer\Hmac\Sha256();
            case "HS384":
                return new \Lcobucci\JWT\Signer\Hmac\Sha384();
            case "HS512":
                return new \Lcobucci\JWT\Signer\Hmac\Sha512();
            case "RS256":
                return new Sha256();
            case "RS384":
                return new Sha384();
            case "RS512":
                return new Sha512();
            case "ES256":
                return new \Lcobucci\JWT\Signer\Ecdsa\Sha256();
            case "ES384":
                return new \Lcobucci\JWT\Signer\Ecdsa\Sha384();
            case "ES512":
                return new \Lcobucci\JWT\Signer\Ecdsa\Sha512();
        }
        throw new TokenValidationException("Algorithm not supported: " . $alg);
    }

    private static function buildPublicKey(JsonWebKey $jwk)
    {
        $exponent = base64_decode($jwk->getE());
        $modulus = base64_decode($jwk->getN());

        $exponent = new BigInteger($exponent, $jwk->getKeySize());
        $modulus = new BigInteger($modulus, $jwk->getKeySize());

        $rsa = new RSA();

        $rsa->loadKey(array("publicExponent" => $exponent, "modulus" => $modulus));

        return $rsa->getPublicKey();
    }
}