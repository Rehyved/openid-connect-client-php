<?php

namespace Rehyved\helper;


class Base64Url
{
    /**
     * Encodes the specified byte array.
     * @param $arg
     * @return mixed|string
     */
    public static function encode($arg)
    {
        $s = base64_encode($arg); // Standard base64 encoder

        $s = explode('=', $s)[0]; // Remove any trailing '='s
        $s = str_replace('+', '-', $s); // 62nd char of encoding
        $s = str_replace('/', '_', $s); //63rd char of encoding

        return $s;
    }

    /**
     * Decodes the specified string.
     * @param string $arg
     * @return bool|string
     * @throws \Exception Illegal base64url string
     */
    public static function decode(string $arg)
    {
        $s = $arg;
        $s = str_replace('-', '+', $s);
        $s = str_replace('_', '/', $s);

        switch (strlen($s) % 4) {
            case 0:
                break;
            case 2:
                $s .= "==";
                break;
            case 3:
                $s .= "=";
                break;
            default:
                throw new \Exception("Illegal base64url string!");
        }

        return base64_decode($s);
    }
}