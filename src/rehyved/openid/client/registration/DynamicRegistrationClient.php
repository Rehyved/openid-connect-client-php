<?php

namespace Rehyved\openid\client\registration;
use Rehyved\http\HttpRequest;
use Rehyved\http\HttpStatus;


/**
 * Client for the OpenID Connect dynamic client registration endpoint
 */
class DynamicRegistrationClient
{
    private $httpRequest;

    private $address;

    /**
     * Initializes a new instance of the DynamicRegistrationClient class.
     * @param string $address
     */
    public function __construct(string $address)
    {
        if (empty($address)) {
            throw new \InvalidArgumentException("Address was null or empty");
        }
        $this->address = $address;

        $this->httpRequest = HttpRequest::create($this->address)->accept("application/json");
    }

    /**
     * Sets the timeout the client should use when doing requests
     * @param int $timeout
     */
    public function setTimeout(int $timeout)
    {
        $this->httpRequest->timeout($timeout);
    }

    /**
     * Gets the address
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Sets the address
     * @param mixed $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * Send a registration message to the endpoint.
     * @param RegistrationRequest $request
     * @param string $token
     * @return RegistrationResponse
     */
    public function register(RegistrationRequest $request, string $token) : RegistrationResponse
    {
        if ($request == null) {
            throw new \InvalidArgumentException("Request was null");
        }
        if (!empty($token)) {
            $this->httpRequest->authorization("Bearer", $token);
        }

        $requestJson = $request->toJson();

        try {
            $response = $this->httpRequest->contentType("application/json")->post("", $requestJson);
            if ($response->getHttpStatus() === HttpStatus::CREATED || $response->getHttpStatus() === HttpStatus::BAD_REQUEST) {
                return RegistrationResponse::fromResponse($response->getContentRaw());
            } else {
                return RegistrationResponse::fromHttpStatus($response->getHttpStatus(), HttpStatus::getReasonPhrase($response->getHttpStatus()));
            }
        } catch (\Exception $e) {
            return RegistrationResponse::fromException($e);
        }
    }
}