<?php

namespace Rehyved\openid\client\discovery;


use Rehyved\helper\JsonHelper;
use Rehyved\helper\StringHelper;
use Rehyved\helper\UrlHelper;
use Rehyved\openid\client\jwk\JsonWebKeySet;
use Rehyved\openid\client\ResponseErrorType;
use Rehyved\http\HttpStatus;

class DiscoveryResponse
{
    private $raw;

    private $json;

    private $isError = false;

    private $statusCode;

    private $error;

    private $errorType;

    private $exception;

    private $keySet;


    private function __construct()
    {
    }

    public static function fromResponse(string $raw, DiscoveryPolicy $policy = null): DiscoveryResponse
    {
        if ($policy == null) {
            $policy = new DiscoveryPolicy();
        }

        $result = new DiscoveryResponse();
        $result->setIsError(false);
        $result->setStatusCode(HttpStatus::OK);
        $result->setRaw($raw);

        try {
            $decoded = JsonHelper::tryParse($raw);

            $result->setJson($decoded);

            $validationError = DiscoveryResponse::validate($result, $policy);

            if (!empty($validationError)) {
                $result->setIsError(true);
                $result->setJson(null);
                $result->setErrorType(ResponseErrorType::POLICY_VIOLATION);
                $result->setError($validationError);
            }
        } catch (\Exception $e) {
            $result->setIsError(true);

            $result->setErrorType(ResponseErrorType::EXCEPTION);
            $result->setError($e->getMessage());
            $result->setException($e);
        }

        return $result;
    }

    public static function fromHttpStatus(int $statusCode, $reason): DiscoveryResponse
    {
        $result = new DiscoveryResponse();
        $result->setIsError(true);

        $result->setErrorType(ResponseErrorType::HTTP);
        $result->setStatusCode($statusCode);
        $result->setError($reason);

        return $result;
    }

    public static function fromException(\Exception $exception, string $errorMessage): DiscoveryResponse
    {
        $result = new DiscoveryResponse();
        $result->setIsError(true);

        $result->setErrorType(ResponseErrorType::EXCEPTION);
        $result->setException($exception);
        $result->setError($errorMessage . ": " . $exception->getMessage());

        return $result;
    }

    private static function validate(DiscoveryResponse $response, DiscoveryPolicy $policy)
    {
        if ($policy->isValidateIssuerName()) {
            $issuer = $response->getIssuer();
            if (empty($issuer)) {
                return "Issuer name is missing";
            }

            $isValid = DiscoveryResponse::validateIssuerName(UrlHelper::removeTrailingSlash($issuer), UrlHelper::removeTrailingSlash($policy->getAuthority()));
            if (!$isValid) {
                return "Issuer name does not match authority: " . $issuer;
            }
        }

        $error = DiscoveryResponse::validateEndpoints($response, $policy);
        if (!empty($error)) {
            return $error;
        }

        return null;
    }

    private static function validateIssuerName($issuer, $authority)
    {
        return $issuer === $authority;
    }

    private static function validateEndpoints(DiscoveryResponse $response, DiscoveryPolicy $policy)
    {
        $json = $response->getJson();
        $allowedHosts = array_map(function ($additionalEndpointBaseAddress) {
            return UrlHelper::getAuthority($additionalEndpointBaseAddress);
        }, $policy->getAdditionalEndpointBaseAddresses());

        $allowedHosts[] = UrlHelper::getAuthority($policy->getAuthority());
        $allowedHosts = array_unique($allowedHosts);

        $allowedAuthorities = $policy->getAdditionalEndpointBaseAddresses();
        $allowedAuthorities[] = $policy->getAuthority();
        $allowedAuthorities = array_unique($allowedAuthorities);

        foreach ($json as $key => $value) {
            if (StringHelper::endsWith($key, "endpoint", false)
                || StringHelper::equals($key, DiscoveryConstants::JWKS_URI, false)
                || StringHelper::equals($key, DiscoveryConstants::CHECK_SESSION_IFRAME, false)
            ) {
                $endpoint = $value;

                $isValidUri = UrlHelper::isValidUrl($endpoint);
                if (!$isValidUri) {
                    return "Malformed endpoint: " . $endpoint;
                }

                if (!DiscoveryUrlHelper::isValidScheme($endpoint)) {
                    return "Malformed endpoint: " . $endpoint;
                }

                if (!DiscoveryUrlHelper::isSecureScheme($endpoint, $policy)) {
                    return "Malformed endpoint: " . $endpoint;
                }

                if ($policy->isValidateEndpoints()) {
                    // if endpoint is on exclude list, don't validate
                    if (in_array($key, $policy->getEndpointValidationExcludeList(), true)) {
                        continue;
                    }

                    $isAllowed = false;
                    foreach ($allowedHosts as $host) {
                        if (StringHelper::equals($host, UrlHelper::getAuthority($endpoint))) {
                            $isAllowed = true;
                        }
                    }

                    if (!$isAllowed) {
                        return "Endpoint is on a different host than authority: " . $endpoint;
                    }

                    $isAllowed = false;
                    foreach ($allowedAuthorities as $authority) {
                        if (StringHelper::startsWith($endpoint, $authority)) {
                            $isAllowed = true;
                        }
                    }

                    if (!$isAllowed) {
                        return "Endpoint belongs to different authority: " . $endpoint;
                    }
                }
            }
        }

        if ($policy->isRequireKeySet()) {
            if (empty($response->getJwksUri())) {
                return "Keyset is missing";
            }
        }

        return null;
    }

    public function getIssuer(): string
    {
        return $this->json->{DiscoveryConstants::ISSUER} ?? "";
    }

    public function getAuthorizeEndpoint(): string
    {
        return $this->json->{DiscoveryConstants::AUTHORIZATION_ENDPOINT} ?? "";
    }

    public function getTokenEndpoint(): string
    {
        return $this->json->{DiscoveryConstants::TOKEN_ENDPOINT} ?? "";
    }

    public function getUserInfoEndpoint(): string
    {
        return $this->json->{DiscoveryConstants::USERINFO_ENDPOINT} ?? "";
    }

    public function getIntrospectionEndpoint(): string
    {
        return $this->json->{DiscoveryConstants::INTROSPECTION_ENDPOINT} ?? "";
    }

    public function getRevocationEndpoint(): string
    {
        return $this->json->{DiscoveryConstants::REVOCATION_ENDPOINT} ?? "";
    }

    public function getJwksUri(): string
    {
        return $this->json->{DiscoveryConstants::JWKS_URI} ?? "";
    }

    public function getEndSessionEndpoint(): string
    {
        return $this->json->{DiscoveryConstants::END_SESSION_ENDPOINT} ?? "";
    }

    public function getCheckSessionIframe(): string
    {
        return $this->json->{DiscoveryConstants::CHECK_SESSION_IFRAME} ?? "";
    }

    public function getRegistrationEndpoint(): string
    {
        return $this->json->{DiscoveryConstants::REGISTRATION_ENDPOINT} ?? "";
    }

    public function isFrontChannelLogoutSupported()
    {
        return $this->json->{DiscoveryConstants::FRONT_CHANNEL_LOGOUT_SUPPORTED} ?? null;
    }

    public function isFrontChannelLogoutSessionSupported()
    {
        return $this->json->{DiscoveryConstants::FRONT_CHANNEL_LOGOUT_SESSION_SUPPORTED} ?? null;
    }

    public function getGrantTypesSupported(): array
    {
        return $this->json->{DiscoveryConstants::GRANT_TYPES_SUPPORTED} ?? array();
    }

    public function getCodeChallengeMethodsSupported(): array
    {
        return $this->json->{DiscoveryConstants::CODE_CHALLENGE_METHODS_SUPPORTED} ?? array();
    }

    public function getScopesSupported(): array
    {
        return $this->json->{DiscoveryConstants::SCOPES_SUPPORTED} ?? array();
    }

    public function getSubjectTypesSupported(): array
    {
        return $this->json->{DiscoveryConstants::SUBJECT_TYPES_SUPPORTED} ?? array();
    }

    public function getResponseModesSupported(): array
    {
        return $this->json->{DiscoveryConstants::RESPONSE_MODES_SUPPORTED} ?? array();
    }

    public function getResponseTypesSupported(): array
    {
        return $this->json->{DiscoveryConstants::RESPONSE_TYPES_SUPPORTED} ?? array();
    }

    public function getClaimsSupported(): array
    {
        return $this->json->{DiscoveryConstants::CLAIMS_SUPPORTED} ?? array();
    }

    public function getTokenEndpointAuthenticationMethodsSupported(): array
    {
        return $this->json->{DiscoveryConstants::TOKEN_ENDPOINT_AUTHENTICATION_METHODS_SUPPORTED} ?? array();
    }

    /**
     * @return string
     */
    public function getRaw(): string
    {
        return $this->raw;
    }

    /**
     * @param string $raw
     */
    private function setRaw(string $raw)
    {
        $this->raw = $raw;
    }

    /**
     * @return mixed
     */
    public function getJson(): \stdClass
    {
        return $this->json;
    }

    /**
     * @param mixed $json
     */
    private function setJson(\stdClass $json)
    {
        $this->json = $json;
    }

    /**
     * @return bool
     */
    public function isError(): bool
    {
        return $this->isError;
    }

    /**
     * @param bool $isError
     */
    private function setIsError(bool $isError)
    {
        $this->isError = $isError;
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * @param int $statusCode
     */
    private function setStatusCode(int $statusCode)
    {
        $this->statusCode = $statusCode;
    }

    /**
     * @return string
     */
    public function getError(): string
    {
        return $this->error;
    }

    /**
     * @param mixed $error
     */
    private function setError(string $error)
    {
        $this->error = $error;
    }

    /**
     * @return string
     */
    public function getErrorType(): string
    {
        return $this->errorType;
    }

    /**
     * @param string $errorType
     */
    public function setErrorType(string $errorType)
    {
        $this->errorType = $errorType;
    }

    /**
     * @return \Exception
     */
    public function getException(): \Exception
    {
        return $this->exception;
    }

    /**
     * @param mixed $exception
     */
    private function setException(\Exception $exception)
    {
        $this->exception = $exception;
    }

    /**
     * @return JsonWebKeySet
     */
    public function getKeySet(): JsonWebKeySet
    {
        return $this->keySet;
    }

    /**
     * @param JsonWebKeySet $keySet
     */
    public function setKeySet(JsonWebKeySet $keySet)
    {
        $this->keySet = $keySet;
    }


}