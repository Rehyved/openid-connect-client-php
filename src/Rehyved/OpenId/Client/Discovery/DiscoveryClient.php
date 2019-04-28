<?php

namespace Rehyved\OpenId\Client\Discovery;

use Jose\Factory\JWKFactory;
use Psr\Cache\CacheItemPoolInterface;
use Rehyved\Utilities\StringHelper;
use Rehyved\Utilities\UrlHelper;

use Rehyved\Http\HttpRequest;
use Rehyved\Http\HttpStatus;

class DiscoveryClient
{

    private $authority;
    private $url;

    private $policy;

    private $timeout = false;

    private $cache;

    public static function parseUrl(string $url)
    {
        $discoveryEndpoint = "";
        $authority = "";

        $url = UrlHelper::validateUrl($url);
        $url = UrlHelper::removeTrailingSlash($url);

        if (StringHelper::contains($url, DiscoveryConstants::DISCOVERY_ENDPOINT)) {
            $discoveryEndpoint = $url;
            $authority = substr($url, 0, stripos($url, DiscoveryConstants::DISCOVERY_ENDPOINT) - 1);
        } else {
            $authority = $url;
            $discoveryEndpoint = UrlHelper::ensureTrailingSlash($url) . DiscoveryConstants::DISCOVERY_ENDPOINT;
        }

        return array($authority, $discoveryEndpoint);
    }

    public function __construct($authority, $policy = null, CacheItemPoolInterface $cache = null)
    {
        list($this->authority, $this->url) = $this->parseUrl($authority);
        $this->policy = $policy ?? new DiscoveryPolicy();
        $this->cache = $cache;
    }

    public function get()
    {
        if (empty($this->policy->getAuthority())) {
            $this->policy->setAuthority($this->authority);
        }

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

                    $jwkSet = JWKFactory::createFromJKU($jwkUrl, $this->policy->isAllowUnsecuredConnections(), $this->cache, 86400, !$this->policy->isRequireHttps());

                    $discoveryResponse->setKeySet($jwkSet);
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