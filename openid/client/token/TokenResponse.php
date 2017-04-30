<?php

namespace com\rehyved\openid\client\token;


use com\rehyved\openid\client\Response;

class TokenResponse extends Response
{
    public static function fromResponse(string $raw)
    {
        $response = new TokenResponse();
        return $response->withResponse($raw);
    }

    public static function fromException(\Exception $exception)
    {
        $response = new TokenResponse();
        return $response->withException($exception);
    }

    public static function fromErrorStatus(int $statusCode, string $reason)
    {
        $response = new TokenResponse();
        return $response->withErrorStatus($statusCode, $reason);
    }

    public function getAccessToken(): string
    {
        return $this->json->{TokenResponseConstants::ACCESS_TOKEN} ?? null;
    }

    public function getIdentityToken(): string
    {
        return $this->json->{TokenResponseConstants::IDENTITY_TOKEN} ?? null;
    }

    public function getTokenType(): string
    {
        return $this->json->{TokenResponseConstants::TOKEN_TYPE} ?? null;
    }

    public function getRefreshToken(): string
    {
        return $this->json->{TokenResponseConstants::REFRESH_TOKEN} ?? null;
    }

    public function getErrorDescription(): string
    {
        return $this->json->{TokenResponseConstants::ERROR_DESCRIPTION} ?? null;
    }

    public function getExpiresIn(): int
    {
        return $this->json->{TokenResponseConstants::EXPIRES_IN} ?? 0;
    }

    /**
     * @return mixed
     */
    public function getRaw()
    {
        return $this->raw;
    }

    /**
     * @return mixed
     */
    public function getJson()
    {
        return $this->json;
    }

    /**
     * @return mixed
     */
    public function getException()
    {
        return $this->exception;
    }

    /**
     * @return string
     */
    public function getErrorType(): string
    {
        return $this->errorType;
    }

    /**
     * @return mixed
     */
    public function getHttpStatusCode()
    {
        return $this->httpStatusCode;
    }

    /**
     * @return mixed
     */
    public function getHttpErrorReason()
    {
        return $this->httpErrorReason;
    }


}