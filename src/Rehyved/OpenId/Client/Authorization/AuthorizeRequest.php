<?php

namespace Rehyved\OpenId\Client\Authorization;


use Rehyved\Utilities\UrlHelper;
use Rehyved\http\HttpStatus;

class AuthorizeRequest
{
    /**
     * Starts an external authorization request.
     * This will redirect to the providers authorization page.
     * @param string $authorizeEndpoint The provider to redirect to.
     * @param string $clientId the client id of the application
     * @param string $redirectUri the uri the authority should redirect the response to
     * @param string $nonce a nonce which helps identifying that a response is caused by this request
     * @param array $scopes the scopes to request
     * @param array $responseTypes the response types to receive i.e. id_token, code etc.
     * @param string $responseMode the way the response should be formatted, defaults to 'form_post'
     * @param array $additionalParameters additional parameters that should be passed to the authority.
     */
    public static function authorize(
        string $authorizeEndpoint,
        string $clientId,
        string $redirectUri,
        string $nonce,
        array $scopes,
        array $responseTypes,
        string $responseMode = ResponseModes::FORM_POST,
        array $additionalParameters = array()
    )
    {
        $parameters = array(
            AuthorizeRequestConstants::CLIENT_ID => $clientId,
            AuthorizeRequestConstants::REDIRECT_URI => $redirectUri,
            AuthorizeRequestConstants::NONCE => $nonce,
            AuthorizeRequestConstants::SCOPE => implode(" ", $scopes),
            AuthorizeRequestConstants::RESPONSE_TYPE => implode(" ", $responseTypes),
            AuthorizeRequestConstants::RESPONSE_MODE => $responseMode
        );
        $parameters = array_merge($parameters, $additionalParameters);

        $authorizeEndpoint = UrlHelper::buildUrl($authorizeEndpoint, $parameters);
        header('Location: ' . $authorizeEndpoint, true, HttpStatus::FOUND);
    }

}