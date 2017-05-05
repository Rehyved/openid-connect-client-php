<?php

namespace Rehyved\openid\client\introspection;

use Rehyved\openid\client\Response;

class IntrospectionResponse extends Response
{
    private $claims = array();

    public static function fromResponse(string $raw)
    {
        $response = new IntrospectionResponse();
        $response->withResponse($raw);

        if (!$response->isError()) {
            $claims = json_decode($response->raw, true);
            if (isset($claims["scope"])) {
                $scope = $claims["scope"];
                if (!is_string($scope)) {
                    $scopes = explode(' ', $scope);
                    $claims["scope"] = array_filter($scopes);
                }
            }
            $response->claims = $claims;
        }
    }

    public static function fromException(\Exception $exception)
    {
        $response = new IntrospectionResponse();
        return $response->withException($exception);
    }

    public static function fromErrorStatus(int $statusCode, string $reason)
    {
        $response = new IntrospectionResponse();
        return $response->withHttpStatus($statusCode, $reason);
    }
}