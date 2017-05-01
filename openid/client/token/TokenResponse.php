<?php

namespace com\rehyved\openid\client\token;


use com\rehyved\openid\client\Response;

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
    public function getAccessToken(): string
    {
        return $this->json->{TokenResponseConstants::ACCESS_TOKEN} ?? null;
    }

    /**
     * Gets the identity token
     * @return string
     */
    public function getIdentityToken(): string
    {
        return $this->json->{TokenResponseConstants::IDENTITY_TOKEN} ?? null;
    }

    /**
     * Gets the token type
     * @return string
     */
    public function getTokenType(): string
    {
        return $this->json->{TokenResponseConstants::TOKEN_TYPE} ?? null;
    }

    /**
     * Gets the refresh token
     * @return string
     */
    public function getRefreshToken(): string
    {
        return $this->json->{TokenResponseConstants::REFRESH_TOKEN} ?? null;
    }

    /**
     * Gets the error description
     * @return string
     */
    public function getErrorDescription(): string
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


}