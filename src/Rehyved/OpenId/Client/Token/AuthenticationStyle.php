<?php

namespace Rehyved\OpenId\Client\Token;


class AuthenticationStyle
{
    /**
     * HTTP basic authentication
     */
    const BASIC_AUTHENTICATION = "BasicAuthentication";

    /**
     * Post values in body
     */
    const POST_VALUES = "PostValues";

    /**
     * Custom
     */
    const CUSTOM = "Custom";
}