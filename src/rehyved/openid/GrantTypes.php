<?php
namespace Rehyved\openid;


class GrantTypes
{
    const PASSWORD = "password";
    const AUTHORIZATION_CODE = "authorization_code";
    const CLIENT_CREDENTIALS = "client_credentials";
    const REFRESH_TOKEN = "refresh_token";
    const IMPLICIT = "implicit";
    const SAML2_BEARER = "urn:ietf:params:oauth:grant-type:saml2-bearer";
    const JWT_BEARER = "urn:ietf:params:oauth:grant-type:jwt-bearer";
}