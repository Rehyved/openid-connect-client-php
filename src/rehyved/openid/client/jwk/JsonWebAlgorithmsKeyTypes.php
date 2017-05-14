<?php

namespace Rehyved\openid\client\jwk;

/**
 * Constants for JsonWebAlgorithms "kty" Key Type (sec 6.1)
 * http://tools.ietf.org/html/rfc7518#section-6.1
 */
class JsonWebAlgorithmsKeyTypes
{
    const RSA = "RSA";
    const ELLIPTIC_CURVE = "EC";
    const OCTET = "oct";
}