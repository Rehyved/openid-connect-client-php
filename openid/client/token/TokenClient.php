<?php

namespace com\rehyved\openid\client\token;


use com\rehyved\openid\client\GrantTypes;
use http\HttpRequest;
use http\HttpStatus;

/**
 * Client for an OpenID Connect/Oauth 2.0 token endpoint
 */
class TokenClient
{
    private $httpRequest;

    private $authenticationStyle;
    private $clientId;
    private $clientSecret;

    /**
     * Initializes a new instance of the TokenClient class
     * @param string $address
     * @param string $clientId
     * @param string $clientSecret
     * @param string $style
     */
    public function __construct(string $address, string $clientId = "", string $clientSecret = "", string $style = "")
    {
        if (empty($address)) {
            throw new \InvalidArgumentException("Address was null or empty.");
        }

        $this->httpRequest = HttpRequest::create($address)->accept("application/json");

        if (empty($clientId) && empty($clientSecret) && empty($style)) {
            $this->authenticationStyle = AuthenticationStyle::CUSTOM;
        } else if (empty($clientSecret) && empty($style)) {
            $this->authenticationStyle = AuthenticationStyle::POST_VALUES;
        } else if (empty($style)) {
            $this->authenticationStyle = AuthenticationStyle::BASIC_AUTHENTICATION;
        }

        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
    }

    /**
     * Gets the authentication style
     * @return string
     */
    public function getAuthenticationStyle(): string
    {
        return $this->authenticationStyle;
    }

    /**
     * Sets the authentication style
     * @param string $authenticationStyle
     */
    public function setAuthenticationStyle(string $authenticationStyle)
    {
        $this->authenticationStyle = $authenticationStyle;
    }

    /**
     * Gets the client id
     * @return string
     */
    public function getClientId(): string
    {
        return $this->clientId;
    }

    /**
     * Sets the client id
     * @param string $clientId
     */
    public function setClientId(string $clientId)
    {
        $this->clientId = $clientId;
    }

    /**
     * Gets the client secret
     * @return string
     */
    public function getClientSecret(): string
    {
        return $this->clientSecret;
    }

    /**
     * Sets the client secret
     * @param string $clientSecret
     */
    public function setClientSecret(string $clientSecret)
    {
        $this->clientSecret = $clientSecret;
    }

    /**
     * Sets the timeout which shall be used for the requests.
     * @param int $timeout
     */
    public function setTimeout(int $timeout)
    {
        $this->httpRequest = $this->httpRequest->timeout($timeout);
    }

    /**
     * Sends a token request
     * @param array $form
     * @return TokenResponse
     */
    public function request(array $form): TokenResponse
    {
        if ($this->authenticationStyle == AuthenticationStyle::BASIC_AUTHENTICATION) {
            $this->httpRequest->basicAuthentication($this->clientId, $this->clientSecret);
        }

        try {
            $response = $this->httpRequest->post("", $form);

            if ($response->getHttpStatus() === HttpStatus::OK || $response->getHttpStatus() == HttpStatus::BAD_REQUEST) {
                $content = $response->getContentRaw();

                return TokenResponse::fromResponse($content);
            } else {
                return TokenResponse::fromHttpStatus($response->getHttpStatus(), HttpStatus::getReasonPhrase($response->getHttpStatus()));
            }
        } catch (\Exception $e) {
            return TokenResponse::fromException($e);
        }
    }

    /**
     * Requests a token based on client credentials
     * @param string $scope
     * @param array|null $extra
     * @return TokenResponse
     */
    public function requestClientCredentials(string $scope = "", array $extra = null): TokenResponse
    {
        $fields = array(TokenRequestConstants::GRANT_TYPE, GrantTypes::CLIENT_CREDENTIALS);

        if (!empty($scope)) {
            $fields[TokenRequestConstants::SCOPE] = $scope;
        }

        return $this->request($this->merge($fields, $extra));
    }

    /**
     * Requests a token using the resource owner password credentials
     * @param $userName
     * @param string $password
     * @param string $scope
     * @param array|null $extra
     * @return TokenResponse
     */
    public function requestResourceOwnerPassword($userName, string $password, string $scope = "", array $extra = null): TokenResponse
    {
        $fields = array(
            TokenRequestConstants::GRANT_TYPE => GrantTypes::PASSWORD,
            TokenRequestConstants::USER_NAME => $userName,
            TokenRequestConstants::PASSWORD => $password
        );

        if (!empty($scope)) {
            $fields[TokenRequestConstants::SCOPE] = $scope;
        }

        return $this->request($this->merge($fields, $extra));
    }

    /**
     * Requests a token using an authorization code
     * @param string $code
     * @param string $redirectUri
     * @param string $codeVerifier
     * @param array $extra
     * @return TokenResponse
     */
    public function requestAuthorizationCode(string $code, string $redirectUri, string $codeVerifier = "", array $extra): TokenResponse
    {
        $fields = array(
            TokenRequestConstants::GRANT_TYPE => GrantTypes::AUTHORIZATION_CODE,
            TokenRequestConstants::CODE => $code,
            TokenRequestConstants::REDIRECT_URI => $redirectUri
        );

        if (!empty($codeVerifier)) {
            $fields[TokenRequestConstants::CODE_VERIFIER] = $codeVerifier;
        }

        return $this->request($this->merge($fields, $extra));
    }

    /**
     * Requests a PoP token using an authorization code
     * @param string $code
     * @param string $redirectUri
     * @param string $codeVerifier
     * @param string $algorithm
     * @param string $key
     * @param array $extra
     * @return TokenResponse
     */
    public function requestAuthorizationCodePop(string $code, string $redirectUri, string $codeVerifier = "", string $algorithm = "", string $key = "", array $extra): TokenResponse
    {
        $fields = array(
            TokenRequestConstants::TOKEN_TYPE => TokenRequestTypes::POP,
            TokenRequestConstants::GRANT_TYPE => GrantTypes::AUTHORIZATION_CODE,
            TokenRequestConstants::CODE => $code,
            TokenRequestConstants::REDIRECT_URI => $redirectUri
        );

        if (!empty($codeVerifier)) {
            $fields[TokenRequestConstants::CODE_VERIFIER] = $codeVerifier;
        }

        if (!empty($algorithm)) {
            $fields[TokenRequestConstants::ALGORITHM] = $algorithm;
        }

        if (!empty($key)) {
            $fields[TokenRequestConstants::KEY] = $key;
        }

        return $this->request($this->merge($fields, $extra));
    }

    /**
     * Requests a token using a refresh token
     * @param string $refreshToken
     * @param array|null $extra
     * @return TokenResponse
     */
    public function requestRefreshToken(string $refreshToken, array $extra = null): TokenResponse
    {
        $fields = array(
            TokenRequestConstants::GRANT_TYPE => GrantTypes::REFRESH_TOKEN,
            TokenRequestConstants::REFRESH_TOKEN => $refreshToken
        );

        return $this->request($this->merge($fields, $extra));
    }

    /**
     * Requesta a PoP token using a refresh token
     * @param string $refreshToken
     * @param string $algorithm
     * @param string $key
     * @param array|null $extra
     * @return TokenResponse
     */
    public function requestRefreshTokenPop(string $refreshToken, string $algorithm = "", string $key = "", array $extra = null): TokenResponse
    {
        $fields = array(
            TokenRequestConstants::TOKEN_TYPE => TokenRequestTypes::POP,
            TokenRequestConstants::GRANT_TYPE => GrantTypes::REFRESH_TOKEN,
            TokenRequestConstants::REFRESH_TOKEN => $refreshToken,
        );

        if (!empty($algorithm)) {
            $fields[TokenRequestConstants::ALGORITHM] = $algorithm;
        }

        if (!empty($key)) {
            $fields[TokenRequestConstants::KEY] = $key;
        }

        return $this->request($this->merge($fields, $extra));
    }

    /**
     * Requests a token using an assertion
     * @param string $assertionType
     * @param string $assertion
     * @param string|null $scope
     * @param array|null $extra
     * @return TokenResponse
     */
    public function requestAssertion(string $assertionType, string $assertion, string $scope = null, array $extra = null): TokenResponse
    {
        $fields = array(
            TokenRequestConstants::GRANT_TYPE => $assertionType,
            TokenRequestConstants::ASSERTION => $assertion,
        );

        if (!empty($scope)) {
            $fields[TokenRequestConstants::SCOPE] = $scope;
        }

        return $this->request($this->merge($fields, $extra));
    }

    /**
     * Requests a token using a custom grant
     * @param string $grantType
     * @param string|null $scope
     * @param array|null $extra
     * @return TokenResponse
     */
    public function requestCustomGrant(string $grantType, string $scope = null, array $extra = null): TokenResponse
    {
        $fields = array(
            TokenRequestConstants::GRANT_TYPE => $grantType,
        );

        if (!empty($scope)) {
            $fields[TokenRequestConstants::SCOPE] = $scope;
        }

        return $this->request($this->merge($fields, $extra));
    }

    /**
     * Requests a token using a custom request
     * @param array $values
     * @return TokenResponse
     */
    public function requestCustom(array $values): TokenResponse
    {
        return $this->request($this->merge($values));
    }

    private function merge(array $explicitValues, array $additionalValues = null)
    {
        $merged = $explicitValues;

        if ($this->authenticationStyle == AuthenticationStyle::POST_VALUES) {
            $merged[TokenRequestConstants::CLIENT_ID] = $this->clientId;

            if (!empty($this->clientSecret)) {
                $merged[TokenRequestConstants::CLIENT_SECRET] = $this->clientSecret;
            }
        }

        if ($additionalValues !== null) {
            $merged = array_merge($additionalValues, $explicitValues);
        }

        return $merged;
    }
}