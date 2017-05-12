<?php

namespace Rehyved\openid\client\discovery;

use Rehyved\helper\StringHelper;
use Rehyved\helper\UrlHelper;
use Rehyved\openid\client\jwk\JsonWebKeySet;

use Rehyved\http\HttpRequest;
use Rehyved\http\HttpStatus;

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

        if (StringHelper::contains($url, DiscoveryConstants::DISCOVERY_ENDPOINT, false)) {
            $discoveryEndpoint = $url;
            $authority = substr($url, 0, stripos($url, DiscoveryConstants::DISCOVERY_ENDPOINT) - 1);
        } else {
            $authority = $url;
            $discoveryEndpoint = UrlHelper::ensureTrailingSlash($url) . DiscoveryConstants::DISCOVERY_ENDPOINT;
        }

        return array($authority, $discoveryEndpoint);
    }

    public function __construct($authority, $policy = null)
    {
        list($this->authority, $this->url) = $this->parseUrl($authority);
        $this->policy = $policy ?? new DiscoveryPolicy();
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