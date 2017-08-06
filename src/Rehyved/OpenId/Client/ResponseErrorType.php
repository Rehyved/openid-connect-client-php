<?php

namespace Rehyved\OpenId\Client;


class ResponseErrorType
{
    const NONE = "None";
    const PROTOCOL = "Protocol";
    const HTTP = "Http";
    const EXCEPTION = "Exception";
    const POLICY_VIOLATION = "PolicyViolation";
}