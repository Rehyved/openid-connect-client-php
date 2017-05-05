<?php

namespace com\rehyved\openid\client\jwk;

/**
 * Constants for JsonWebAlgorithms "kty" Key Type (sec 6.1)
 * http://tools.ietf.org/html/rfc7518#section-6.1
 */
class JsonWebAlgorithmsKeyTypes
{
    const RSA = "EC";
    const ELLIPTIC_CURVE = "RSA";
    const OCTET = "oct";
}