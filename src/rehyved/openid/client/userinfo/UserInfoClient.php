<?php

namespace Rehyved\openid\client\userinfo;
use Rehyved\http\HttpRequest;
use Rehyved\http\HttpStatus;


/**
 * Client for an OpenID Connect userinfo endpoint
 */
class UserInfoClient
{
    private $httpRequest;

    /**
     * Initializes a new instance of the UserInfoClient class.
     * @param string $endpoint
     */
    public function __construct(string $endpoint)
    {
        if (empty($endpoint)) {
            throw new \InvalidArgumentException("Endpoint was null or empty");
        }

        $this->httpRequest = HttpRequest::create($endpoint)->accept("application/json");
    }

    /**
     * Sets the timeout to be used by the client for the requests
     * @param int $timeout
     */
    public function setTimeout(int $timeout)
    {
        $this->httpRequest->timeout($timeout);
    }

    /**
     * Sends the userinfo request.
     * @param string $token
     * @return UserInfoResponse
     */
    public function get(string $token) : UserInfoResponse
    {
        if (empty($token)) {
            throw new \InvalidArgumentException("Token was null or empty");
        }

        $this->httpRequest->authorization("Bearer", $token);

        try {
            $response = $this->httpRequest->get();
            if ($response->isError()) {
                return UserInfoResponse::fromHttpStatus($response->getHttpStatus(), HttpStatus::getReasonPhrase($response->getHttpStatus()));
            }
            return UserInfoResponse::fromResponse($response->getContentRaw());
        } catch (\Exception $e) {
            return UserInfoResponse::fromException($e);
        }
    }
}