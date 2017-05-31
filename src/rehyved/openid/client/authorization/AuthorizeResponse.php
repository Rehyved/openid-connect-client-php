<?php

namespace Rehyved\openid\client\authorization;


use Rehyved\utilities\StringHelper;

class AuthorizeResponse
{
    private $raw;

    private $values = array();

    public function __construct($raw)
    {
        $this->raw = $raw;
        $this->parseRaw();
    }

    private function parseRaw()
    {
        if (is_object($this->raw) || is_array($this->raw)) {
            $this->values = (array)$this->raw;
            return;
        }

        $fragments = array();

        if (StringHelper::contains($this->raw, '?')) {
            // query string encoded

            $fragments = explode("?", $this->raw);
            $additionalHashFragment = strpos($fragments[1], '#');
            if ($additionalHashFragment !== false) {
                $fragments[1] = substr($fragments[1], 0, $additionalHashFragment);
            }
        } else if (StringHelper::contains($this->raw, '#')) {
            // fragment encoded

            $fragments = explode('#', $this->raw);
        } else {
            // form encoded

            $fragments = array("", $this->raw);
        }

        $parameters = explode('&', $fragments[1]);

        foreach ($parameters as $parameter) {
            $parts = explode('=', $parameter);

            if (count($parts) == 2) {
                $this->values[$parts[0]] = $parts[1];
            } else {
                throw new \InvalidArgumentException("Malformed authorization callback data.");
            }
        }
    }

    public function getCode()
    {
        return $this->tryGet(AuthorizeResponseConstants::CODE);
    }

    public function getAccessToken()
    {
        return $this->tryGet(AuthorizeResponseConstants::ACCESS_TOKEN);
    }

    public function getIdentityToken()
    {
        return $this->tryGet(AuthorizeResponseConstants::IDENTITY_TOKEN);
    }

    public function getError()
    {
        return $this->tryGet(AuthorizeResponseConstants::ERROR);
    }

    public function getErrorDescription()
    {
        return $this->tryGet(AuthorizeResponseConstants::ERROR_DESCRIPTION);
    }

    public function isError()
    {
        return !empty($this->getError());
    }

    public function getScope()
    {
        return $this->tryGet(AuthorizeResponseConstants::SCOPE);
    }

    public function getTokenType()
    {
        return $this->tryGet(AuthorizeResponseConstants::TOKEN_TYPE);
    }

    public function getState()
    {
        return $this->tryGet(AuthorizeResponseConstants::STATE);
    }

    public function getExpiresIn()
    {
        return $this->tryGet(AuthorizeResponseConstants::EXPIRES_IN);
    }

    public function tryGet(string $type)
    {
        if (array_key_exists($type, $this->values)) {
            return urldecode($this->values[$type]);
        }
        return null;
    }
}