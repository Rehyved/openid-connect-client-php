<?php

namespace com\rehyved\openid\client\token;


use com\rehyved\openid\client\Response;
use Rehyved\http\HttpStatus;

class TokenRevocationResponse extends Response
{
    public function __construct()
    {
        $this->withHttpStatus(HttpStatus::OK, HttpStatus::getReasonPhrase(HttpStatus::OK));
    }

    /**
     * Initializes a new instance of the TokenRevocationResponse class based on the response data.
     * @param string $raw
     * @return TokenRevocationResponse
     */
    public static function fromResponse(string $raw): TokenRevocationResponse
    {
        $response = new TokenRevocationResponse();
        return $response->withResponse($raw);
    }

    /**
     * Initializes a new instance of the TokenRevocationResponse class based on an exception.
     * @param \Exception $exception
     * @return TokenRevocationResponse
     */
    public static function fromException(\Exception $exception): TokenRevocationResponse
    {
        $response = new TokenRevocationResponse();
        return $response->withException($exception);
    }

    /**
     * Initializes a new instance of the TokenRevocationResponse class based on a HTTP status code and reason.
     * @param int $statusCode
     * @param string $reason
     * @return TokenRevocationResponse
     */
    public static function fromErrorStatus(int $statusCode, string $reason): TokenRevocationResponse
    {
        $response = new TokenRevocationResponse();
        return $response->withHttpStatus($statusCode, $reason);
    }
}