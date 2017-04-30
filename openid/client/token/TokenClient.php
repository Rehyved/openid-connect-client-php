<?php

namespace com\rehyved\openid\client\token;


use com\rehyved\openid\client\GrantTypes;
use http\HttpRequest;
use http\HttpStatus;

class TokenClient
{
    private $httpRequest;

    private $authenticationStyle;
    private $clientId;
    private $clientSecret;

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
     * @return string
     */
    public function getAuthenticationStyle(): string
    {
        return $this->authenticationStyle;
    }

    /**
     * @param string $authenticationStyle
     */
    public function setAuthenticationStyle(string $authenticationStyle)
    {
        $this->authenticationStyle = $authenticationStyle;
    }

    /**
     * @return string
     */
    public function getClientId(): string
    {
        return $this->clientId;
    }

    /**
     * @param string $clientId
     */
    public function setClientId(string $clientId)
    {
        $this->clientId = $clientId;
    }

    /**
     * @return string
     */
    public function getClientSecret(): string
    {
        return $this->clientSecret;
    }

    /**
     * @param string $clientSecret
     */
    public function setClientSecret(string $clientSecret)
    {
        $this->clientSecret = $clientSecret;
    }

    public function setTimeout(int $timeout)
    {
        $this->httpRequest = $this->httpRequest->timeout($timeout);
    }

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
                return TokenResponse::fromErrorStatus($response->getHttpStatus(), HttpStatus::getReasonPhrase($response->getHttpStatus()));
            }
        } catch (\Exception $e) {
            return TokenResponse::fromException($e);
        }
    }

    public function requestClientCredentials(string $scope = "", array $extra = null)
    {
        $fields = array(TokenRequestConstants::GRANT_TYPE, GrantTypes::CLIENT_CREDENTIALS);

        if (!empty($scope)) {
            $fields[TokenRequestConstants::SCOPE] = $scope;
        }

        return $this->request($this->merge($fields, $extra));
    }

    public function requestResourceOwnerPassword($userName, string $password, string $scope = "", array $extra = null)
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

    public function requestAuthorizationCode(string $code, string $redirectUri, string $codeVerifier = "", array $extra)
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

    public function requestAuthorizationCodePop(string $code, string $redirectUri, string $codeVerifier = "", string $algorithm = "", string $key = "", array $extra)
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

    public function requestRefreshToken(string $refreshToken, array $extra = null)
    {
        $fields = array(
            TokenRequestConstants::GRANT_TYPE => GrantTypes::REFRESH_TOKEN,
            TokenRequestConstants::REFRESH_TOKEN => $refreshToken
        );

        return $this->request($this->merge($fields, $extra));
    }

    public function requestRefreshTokenPop(string $refreshToken, string $algorithm = "", string $key = "", array $extra = null)
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

    public function requestAssertion(string $assertionType, string $assertion, string $scope = null, array $extra = null)
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

    public function requestCustomGrant(string $grantType, string $scope = null, array $extra = null)
    {
        $fields = array(
            TokenRequestConstants::GRANT_TYPE => $grantType,
        );

        if (!empty($scope)) {
            $fields[TokenRequestConstants::SCOPE] = $scope;
        }

        return $this->request($this->merge($fields, $extra));
    }

    public function requestCustom(array $values)
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