<?php

namespace com\rehyved\openid\client\discovery;

class DiscoveryConstants
{

    const ISSUER = "issuer";

    // endpoints
    const AUTHORIZATION_ENDPOINT = "authorization_endpoint";
    const TOKEN_ENDPOINT = "token_endpoint";
    const USERINFO_ENDPOINT = "userinfo_endpoint";
    const INTROSPECTION_ENDPOINT = "introspection_endpoint";
    const REVOCATION_ENDPOINT = "revocation_endpoint";
    const DISCOVERY_ENDPOINT = ".well-known/openid-configuration";
    const JWKS_URI = "jwks_uri";
    const END_SESSION_ENDPOINT = "end_session_endpoint";
    const CHECK_SESSION_IFRAME = "check_session_iframe";
    const REGISTRATION_ENDPOINT = "registration_endpoint";

    // common capabilities
    const FRONT_CHANNEL_LOGOUT_SUPPORTED = "frontchannel_logout_supported";
    const FRONT_CHANNEL_LOGOUT_SESSION_SUPPORTED = "frontchannel_logout_session_supported";
    const GRANT_TYPES_SUPPORTED = "grant_types_supported";
    const CODE_CHALLENGE_METHODS_SUPPORTED = "code_challenge_methods_supported";
    const SCOPES_SUPPORTED = "scopes_supported";
    const SUBJECT_TYPES_SUPPORTED = "subject_types_supported";
    const RESPONSE_MODES_SUPPORTED = "response_modes_supported";
    const RESPONSE_TYPES_SUPPORTED = "response_types_supported";
    const CLAIMS_SUPPORTED = "claims_supported";
    const TOKEN_ENDPOINT_AUTHENTICATION_METHODS_SUPPORTED = "token_endpoint_auth_methods_supported";

    // more capabilities
    const CLAIMS_LOCALES_SUPPORTED = "claims_locales_supported";
    const CLAIMS_PARAMETER_SUPPORTED = "claims_parameter_supported";
    const CLAIM_TYPES_SUPPORTED = "claim_types_supported";
    const DISPLAY_VALUES_SUPPORTED = "display_values_supported";
    const ACR_VALUES_SUPPORTED = "acr_values_supported";
    const ID_TOKEN_ENCRYPTION_ALGORITHMS_SUPPORTED = "id_token_encryption_alg_values_supported";
    const ID_TOKEN_ENCRYPTION_ENC_VALUES_SUPPORTED = "id_token_encryption_enc_values_supported";
    const ID_TOKEN_SIGNING_ALGORITHMS_SUPPORTED = "id_token_signing_alg_values_supported";
    const OP_POLICY_URI = "op_policy_uri";
    const OP_TOS_URI = "op_tos_uri";
    const REQUEST_OBJECT_ENCRYPTION_ALGORITHMS_SUPPORTED = "request_object_encryption_alg_values_supported";
    const REQUEST_OBJECT_ENCRYPTION_ENC_VALUES_SUPPORTED = "request_object_encryption_enc_values_supported";
    const REQUEST_OBJECT_SIGNING_ALGORITHMS_SUPPORTED = "request_object_signing_alg_values_supported";
    const REQUEST_PARAMETER_SUPPORTED = "request_parameter_supported";
    const REQUEST_URI_PARAMETER_SUPPORTED = "request_uri_parameter_supported";
    const REQUIRE_REQUEST_URI_REGISTRATION = "require_request_uri_registration";
    const SERVICE_DOCUMENTATION = "service_documentation";
    const TOKEN_ENDPOINT_AUTH_SIGNING_ALGORITHMS_SUPPORTED = "token_endpoint_auth_signing_alg_values_supported";
    const UI_LOCALES_SUPPORTED = "ui_locales_supported";
    const USER_INFO_ENCRYPTION_ALGORITHMS_SUPPORTED = "userinfo_encryption_alg_values_supported";
    const USER_INFO_ENCRYPTION_ENC_VALUES_SUPPORTED = "userinfo_encryption_enc_values_supported";
    const USER_INFO_SIGNING_ALGORITHMS_SUPPORTED = "userinfo_signing_alg_values_supported";
}