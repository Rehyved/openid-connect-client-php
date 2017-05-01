<?php

namespace com\rehyved\openid\client\discovery;

use com\rehyved\helper\StringHelper;
use com\rehyved\helper\UrlHelper;
use com\rehyved\openid\client\jwk\JsonWebKeySet;
use com\rehyved\openid\client\discovery\DiscoveryConstants;
use http\HttpRequest;
use http\HttpStatus;

class DiscoveryClient
{

    private $authority;
    private $url;

    private $policy;

    private $timeout = false;

    public static function parseUrl(string $url)
    {
        $discoveryEndpoint = "";
        $authority = "";

        $url = UrlHelper::validateUrl($url);
        $url = UrlHelper::removeTrailingSlash($url);

        if (StringHelper::endsWith($url, DiscoveryConstants::DISCOVERY_ENDPOINT, false)) {
            $discoveryEndpoint = $url;
            $authority = substr($url, 0, strlen($url) - strlen(DiscoveryConstants::DISCOVERY_ENDPOINT) - 1);
        } else {
            $authority = $url;
            $discoveryEndpoint = UrlHelper::ensureTrailingSlash($url) . DiscoveryConstants::DISCOVERY_ENDPOINT;
        }

        return array($authority, $discoveryEndpoint);
    }

    public function __construct($authority)
    {
        list($this->authority, $this->url) = $this->parseUrl($authority);
        $this->policy = new DiscoveryPolicy();
    }

    public function get()
    {
        $this->policy->setAuthority($this->authority);

        $jwkUrl = "";

        if (!DiscoveryUrlHelper::isSecureScheme($this->url, $this->policy)) {
            return DiscoveryResponse::fromException(new \InvalidArgumentException("HTTPS required"), "Error connecting to " . $this->url);
        }

        try {
            $request = HttpRequest::create($this->url);
            if ($this->timeout !== false) {
                $request = $request->timeout($this->timeout);
            }
            $response = $request->get();

            if ($response->isError()) {
                return DiscoveryResponse::fromHttpStatus(
                    $response->getHttpStatus(),
                    "Error connecting to " . $this->url . ": " . HttpStatus::getReasonPhrase($response->getHttpStatus())
                );
            }

            $discoveryResponse = DiscoveryResponse::fromResponse($response->getContentRaw(), $this->policy);
            if ($discoveryResponse->isError()) {
                return $discoveryResponse;
            }

            try {
                $jwkUrl = $discoveryResponse->getJwksUri();


                if ($jwkUrl != null) {
                    $request = HttpRequest::create($jwkUrl);
                    if ($this->timeout !== false) {
                        $request = $request->timeout($this->timeout);
                    }
                    $response = $request->get();

                    if ($response->isError()) {
                        return DiscoveryResponse::fromHttpStatus(
                            $response->getHttpStatus(),
                            "Error connecting to " . $jwkUrl . ": " . HttpStatus::getReasonPhrase($response->getHttpStatus())
                        );
                    }
                    $jwk = $response->getContentRaw();
                    $discoveryResponse->setKeySet(new JsonWebKeySet($jwk));
                }

                return $discoveryResponse;
            } catch (\Exception $jwkException) {
                return DiscoveryResponse::fromException($jwkException, "Error connecting to " . $jwkUrl);
            }
        } catch (\Exception $exception) {
            return DiscoveryResponse::fromException($exception, "Error connecting to " . $this->url);
        }
    }

    /**
     * @param mixed $timeout
     */
    public function setTimeout($timeout)
    {
        $this->timeout = $timeout;
    }

}