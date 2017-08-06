<?php

namespace Rehyved\OpenId\Client\Jwk;


class JsonWebAlgorithms
{
    const HS256 = 'HS256';
    const HS384 = 'HS384';
    const HS512 = 'HS512';
    const RS256 = 'RS256';
    const RS384 = 'RS384';
    const RS512 = 'RS512';
    const ES256 = 'ES256';
    const ES384 = 'ES384';
    const ES512 = 'ES512';

    public static function all(): array
    {
        return array(
            JsonWebAlgorithms::HS256,
            JsonWebAlgorithms::HS384,
            JsonWebAlgorithms::HS512,
            JsonWebAlgorithms::RS256,
            JsonWebAlgorithms::RS384,
            JsonWebAlgorithms::RS512,
            JsonWebAlgorithms::ES256,
            JsonWebAlgorithms::ES384,
            JsonWebAlgorithms::ES512
        );
    }
}