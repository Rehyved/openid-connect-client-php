<?php

namespace Rehyved\openid\client\token;

use Rehyved\http\HttpRequest;
use Rehyved\http\HttpStatus;

/**
 * Client for an OAuth 2.0 token revocation endpoint
 */
class TokenRevocationClient
{
    private $httpRequest;

    private $clientId;
    private $clientSecret;

    public function __construct(string $endpoint, string $clientId = "", string $clientSecret = "")
    {
        if (empty($endpoint)) {
            throw new \InvalidArgumentException("Endpoint was null or empty");
        }

        $this->httpRequest = HttpRequest::create($endpoint)->accept("application/json");

        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;

        if (!empty($clientId && !empty($clientSecret))) {
            $this->httpRequest->basicAuthentication($clientId, $clientSecret);
        }
    }

    /**
     * Sets the timeout with which the client should do requests.
     * @param int $timeout
     */
    public function setTimeout(int $timeout)
    {
        $this->httpRequest->timeout($timeout);
    }

    /**
     * Sends a token revocation request
     * @param TokenRevocationRequest $request
     * @return TokenRevocationResponse
     */
    public function revoke(TokenRevocationRequest $request) : TokenRevocationResponse
    {
        if ($request === null) {
            throw new \InvalidArgumentException("TokenRevocationRequest was null");
        }
        if (empty($request->getToken())) {
            throw new \InvalidArgumentException("Token was null or empty");
        }

        $form = array(TokenRevocationConstants::TOKEN => $request->getToken());

        if (!empty($request->getTokenTypeHint())) {
            $form[TokenRevocationConstants::TOKEN_TYPE_HINT] = $request->getTokenTypeHint();
        }

        if (!empty($request->getClientId())) {
            $form[TokenRevocationConstants::CLIENT_ID] = $request->getClientId();
        } else if (!empty($this->clientId)) {
            $form[TokenRevocationConstants::CLIENT_ID] = $this->clientId;
        }

        if (!empty($request->getClientSecret())) {
            $form[TokenRevocationConstants::CLIENT_SECRET] = $request->getClientSecret();
        }

        try {
            $response = $this->httpRequest->post("", $form);
            if ($response->getHttpStatus() == HttpStatus::OK) {
                return new TokenRevocationResponse();
            } else if ($response->getHttpStatus() == HttpStatus::BAD_REQUEST) {
                return TokenRevocationResponse::fromResponse($response->getContentRaw());
            } else {
                return TokenRevocationResponse::fromErrorStatus($response->getHttpStatus(), HttpStatus::getReasonPhrase($response->getHttpStatus()));
            }
        } catch (\Exception $e) {
            return TokenRevocationResponse::fromException($e);
        }
    }

    /**
     * Gets the client id
     * @return mixed
     */
    public function getClientId()
    {
        return $this->clientId;
    }

    /**
     * Sets the client id
     * @param mixed $clientId
     */
    public function setClientId($clientId)
    {
        $this->clientId = $clientId;
    }

    /**
     * Gets the client secret
     * @return mixed
     */
    public function getClientSecret()
    {
        return $this->clientSecret;
    }

    /**
     * Sets the client secret
     * @param mixed $clientSecret
     */
    public function setClientSecret($clientSecret)
    {
        $this->clientSecret = $clientSecret;
    }


}