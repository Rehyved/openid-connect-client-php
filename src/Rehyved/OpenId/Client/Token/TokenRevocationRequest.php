<?php

namespace Rehyved\OpenId\Client\Token;

/**
 * Models an OAuth 2.0 token revocation request
 */
class TokenRevocationRequest
{
    private $token;
    private $tokenTypeHint;
    private $clientId;
    private $clientSecret;

    /**
     * Gets the token
     * @return mixed
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Sets the token
     * @param mixed $token
     */
    public function setToken($token)
    {
        $this->token = $token;
    }

    /**
     * Gets the token type hint
     * @return mixed
     */
    public function getTokenTypeHint()
    {
        return $this->tokenTypeHint;
    }

    /**
     * Sets the token type hint
     * @param mixed $tokenTypeHint
     */
    public function setTokenTypeHint($tokenTypeHint)
    {
        $this->tokenTypeHint = $tokenTypeHint;
    }

    /**
     * Gets the client identifier
     * @return mixed
     */
    public function getClientId()
    {
        return $this->clientId;
    }

    /**
     * Sets the client identifier
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