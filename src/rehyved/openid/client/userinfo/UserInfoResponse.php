<?php

namespace Rehyved\openid\client\userinfo;

use Rehyved\openid\client\Response;

/**
 * Models an OpenID Connect userinfo response
 */
class UserInfoResponse extends Response
{
    private $claims;

    /**
     * Initializes a new instance of the UserInfoResponse class based on the response data.
     * @param string $raw
     * @return UserInfoResponse
     */
    public static function fromResponse(string $raw): UserInfoResponse
    {
        $response = new UserInfoResponse();
        $response->withResponse($raw);
        if(!$response->isError()){
            $response->claims = json_decode($response->raw, true);
        }
    }

    /**
     * Initializes a new instance of the UserInfoResponse class based on an exception.
     * @param \Exception $exception
     * @return UserInfoResponse
     */
    public static function fromException(\Exception $exception): UserInfoResponse
    {
        $response = new UserInfoResponse();
        return $response->withException($exception);
    }

    /**
     * Initializes a new instance of the UserInfoResponse class based on a HTTP status code and reason.
     * @param int $statusCode
     * @param string $reason
     * @return UserInfoResponse
     */
    public static function fromHttpStatus(int $statusCode, string $reason): UserInfoResponse
    {
        $response = new UserInfoResponse();
        return $response->withHttpStatus($statusCode, $reason);
    }

    /**
     * Gets the claims
     * @return mixed
     */
    public function getClaims()
    {
        return $this->claims;
    }
}