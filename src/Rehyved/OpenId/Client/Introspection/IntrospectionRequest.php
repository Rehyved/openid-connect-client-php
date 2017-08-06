<?php
namespace Rehyved\OpenId\Client\Introspection;


class IntrospectionRequest
{
    private $token;
    private $tokenTypeHint;
    private $clientId;
    private $clientSecret;

    /**
     * @return mixed
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param mixed $token
     */
    public function setToken($token)
    {
        $this->token = $token;
    }

    /**
     * @return mixed
     */
    public function getTokenTypeHint()
    {
        return $this->tokenTypeHint;
    }

    /**
     * @param mixed $tokenTypeHint
     */
    public function setTokenTypeHint($tokenTypeHint)
    {
        $this->tokenTypeHint = $tokenTypeHint;
    }

    /**
     * @return mixed
     */
    public function getClientId()
    {
        return $this->clientId;
    }

    /**
     * @param mixed $clientId
     */
    public function setClientId($clientId)
    {
        $this->clientId = $clientId;
    }

    /**
     * @return mixed
     */
    public function getClientSecret()
    {
        return $this->clientSecret;
    }

    /**
     * @param mixed $clientSecret
     */
    public function setClientSecret($clientSecret)
    {
        $this->clientSecret = $clientSecret;
    }
}