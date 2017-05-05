<?php

namespace Rehyved\openid\client\registration;


use Rehyved\openid\client\Response;

class RegistrationResponse extends Response
{
    /**
     * Initializes a new instance of the RegistrationResponse class based on the response data.
     * @param string $raw
     * @return RegistrationResponse
     */
    public static function fromResponse(string $raw): RegistrationResponse
    {
        $response = new RegistrationResponse();
        return $response->withResponse($raw);
    }

    /**
     * Initializes a new instance of the RegistrationResponse class based on an exception.
     * @param \Exception $exception
     * @return RegistrationResponse
     */
    public static function fromException(\Exception $exception): RegistrationResponse
    {
        $response = new RegistrationResponse();
        return $response->withException($exception);
    }

    /**
     * Initializes a new instance of the RegistrationResponse class based on a HTTP status code and reason.
     * @param int $statusCode
     * @param string $reason
     * @return RegistrationResponse
     */
    public static function fromHttpStatus(int $statusCode, string $reason): RegistrationResponse
    {
        $response = new RegistrationResponse();
        return $response->withHttpStatus($statusCode, $reason);
    }

    public function getErrorDescription()
    {
        return $this->json->{RegistrationResponseConstants::ERROR_DESCRIPTION} ?? null;
    }

    public function getClientId()
    {
        return $this->json->{RegistrationResponseConstants::CLIENT_ID} ?? null;
    }

    public function getClientSecret()
    {
        return $this->json->{RegistrationResponseConstants::CLIENT_SECRET} ?? null;
    }

    public function getRegistrationAccessToken()
    {
        return $this->json->{RegistrationResponseConstants::REGISTRATION_ACCESS_TOKEN} ?? null;
    }

    public function getRegistrationClientUri()
    {
        return $this->json->{RegistrationResponseConstants::REGISTRATION_CLIENT_URI} ?? null;
    }

    public function getClientIdIssuedAt()
    {
        return $this->json->{RegistrationResponseConstants::CLIENT_ID_ISSUED_AT} ?? null;
    }

    public function getClientSecretExpiresAt()
    {
        return $this->json->{RegistrationResponseConstants::CLIENT_SECRET_EXPIRES_AT} ?? null;
    }
}