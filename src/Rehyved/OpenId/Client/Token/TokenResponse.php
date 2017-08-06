<?php

namespace Rehyved\OpenId\Client\Token;


use Rehyved\OpenId\Client\Response;

/**
 * Models a response from an OpenID Connect/OAuth 2.0 token endpoint
 */
class TokenResponse extends Response
{
    private function __construct()
    {
    }

    /**
     * Initializes a new instance of the TokenResponse class based on the response data.
     * @param string $raw
     * @return TokenResponse
     */
    public static function fromResponse(string $raw): TokenResponse
    {
        $response = new TokenResponse();
        return $response->withResponse($raw);
    }

    /**
     * Initializes a new instance of the TokenResponse class based on an exception.
     * @param \Exception $exception
     * @return TokenResponse
     */
    public static function fromException(\Exception $exception): TokenResponse
    {
        $response = new TokenResponse();
        return $response->withException($exception);
    }

    /**
     * Initializes a new instance of the TokenResponse class based on a HTTP status code and reason.
     * @param int $statusCode
     * @param string $reason
     * @return TokenResponse
     */
    public static function fromHttpStatus(int $statusCode, string $reason): TokenResponse
    {
        $response = new TokenResponse();
        return $response->withHttpStatus($statusCode, $reason);
    }

    /**
     * Gets the access token
     * @return string
     */
    public function getAccessToken()
    {
        return $this->json->{TokenResponseConstants::ACCESS_TOKEN} ?? null;
    }

    /**
     * Gets the identity token
     * @return string
     */
    public function getIdentityToken()
    {
        return $this->json->{TokenResponseConstants::IDENTITY_TOKEN} ?? null;
    }

    /**
     * Gets the token type
     * @return string
     */
    public function getTokenType()
    {
        return $this->json->{TokenResponseConstants::TOKEN_TYPE} ?? null;
    }

    /**
     * Gets the refresh token
     * @return string
     */
    public function getRefreshToken()
    {
        return $this->json->{TokenResponseConstants::REFRESH_TOKEN} ?? null;
    }

    /**
     * Gets the refresh token expires in
     * @return string
     */
    public function getRefreshTokenExpiresIn()
    {
        return $this->json->{TokenResponseConstants::REFRESH_TOKEN_EXPIRES_IN} ?? null;
    }

    /**
     * Gets the error description
     * @return string
     */
    public function getErrorDescription()
    {
        return $this->json->{TokenResponseConstants::ERROR_DESCRIPTION} ?? null;
    }

    /**
     * Gets the expires in
     * @return int
     */
    public function getExpiresIn(): int
    {
        return $this->json->{TokenResponseConstants::EXPIRES_IN} ?? 0;
    }

    /**
     * Gets the expires on
     * @return int
     */
    public function getExpiresOn(): int
    {
        return $this->json->{TokenResponseConstants::EXPIRES_ON} ?? 0;
    }

    /**
     * Gets the not before
     * @return int
     */
    public function getNotBefore(): int
    {
        return $this->json->{TokenResponseConstants::NOT_BEFORE} ?? 0;
    }


}