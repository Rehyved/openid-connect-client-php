<?php

namespace Rehyved\OpenId\Client\Introspection;

use Rehyved\Http\HttpRequest;
use Rehyved\Http\HttpStatus;

class IntrospectionClient
{
    private $httpRequest;
    private $clientId;

    public function __construct(string $endpoint, string $clientId, string $clientSecret)
    {
        if (empty($endpoint)) {
            throw new \InvalidArgumentException("endpoint was null or empty");
        }

        $this->httpRequest = HttpRequest::create($endpoint)->accept("application/json");

        if (!empty($clientId) && !empty($clientSecret)) {
            $this->httpRequest->basicAuthentication($clientId, $clientSecret);
        }
        if (!empty($clientId)) {
            $this->clientId = $clientId;
        }
    }

    public function setTimeout(int $timeout)
    {
        $this->httpRequest = $this->httpRequest->timeout($timeout);
    }

    public function send(IntrospectionRequest $request)
    {
        if ($request == null) {
            throw new \InvalidArgumentException("Request was null");
        }
        if (empty($request->getToken())) {
            throw new \InvalidArgumentException("Token was null or empty");
        }

        $form = array();
        $form["token"] = $request->getToken();

        if (!empty($request->getTokenTypeHint())) {
            $form["token_type_hint"] = $request->getTokenTypeHint();
        }
        if (!empty($request->getClientId())) {
            $form["client_id"] = $request->getClientId();
        } else if (!empty($this->clientId)) {
            $form["client_id"] = $this->clientId;
        }

        if (!empty($request->getClientSecret())) {
            $form["client_secret"] = $request->getClientSecret();
        }

        try {
            $response = $this->httpRequest->contentType("application/x-www-form-urlencoded")->post('', $form);
            if (!$response->isError()) {
                return IntrospectionResponse::fromResponse($response->getContentRaw());
            } else {
                return IntrospectionResponse::fromErrorStatus($response->getHttpStatus(), HttpStatus::getReasonPhrase($response->getHttpStatus()));
            }
        } catch (\Exception $e) {
            return IntrospectionResponse::fromException($e);
        }
    }
}