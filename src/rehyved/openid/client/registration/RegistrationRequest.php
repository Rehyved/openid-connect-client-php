<?php

namespace com\rehyved\openid\client\registration;

use com\rehyved\openid\client\ClientMetadataConstants;
use com\rehyved\openid\client\jwk\JsonWebKeySet;

/**
 * Models an OpenID Connect dynamic client registration request
 */
class RegistrationRequest
{
    private $redirectUris;
    private $responseTypes;
    private $grantTypes;
    private $applicationType;
    private $contacts;
    private $clientName;
    private $logoUri;
    private $clientUri;
    private $policyUri;
    private $tosUri;
    private $jwksUri;
    private $jwks;
    private $sectorIdentifierUri;
    private $subjectType;
    private $identityTokenSignedResponseAlgorithm;
    private $identityTokenEncryptedResponseAlgorithm;
    private $identityTokenEncryptedResponseEncryption;
    private $userInfoSignedResponseAlgorithm;
    private $userInfoEncryptedResponseAlgorithm;
    private $userInfoEncryptedResponseEncryption;
    private $requestObjectSigningAlgorithm;
    private $requestObjectEncryptionAlgorithm;
    private $requestObjectEncryptionEncryption;
    private $tokenEndpointAuthenticationMethod;
    private $tokenEndpointAuthenticationSigningAlgorithm;
    private $defaultMaxAge;
    private $requireAuthenticationTime;
    private $defaultAcrValues;
    private $initiateLoginUri;
    private $requestUris;

    /**
     * @return mixed
     */
    public function getRedirectUris(): array
    {
        return $this->redirectUris;
    }

    /**
     * @param mixed $redirectUris
     */
    public function setRedirectUris(array $redirectUris)
    {
        $this->redirectUris = $redirectUris;
    }

    /**
     * @return mixed
     */
    public function getResponseTypes(): array
    {
        return $this->responseTypes;
    }

    /**
     * @param mixed $responseTypes
     */
    public function setResponseTypes(array $responseTypes)
    {
        $this->responseTypes = $responseTypes;
    }

    /**
     * @return mixed
     */
    public function getGrantTypes(): array
    {
        return $this->grantTypes;
    }

    /**
     * @param mixed $grantTypes
     */
    public function setGrantTypes(array $grantTypes)
    {
        $this->grantTypes = $grantTypes;
    }

    /**
     * @return mixed
     */
    public function getApplicationType(): string
    {
        return $this->applicationType;
    }

    /**
     * @param mixed $applicationType
     */
    public function setApplicationType(string $applicationType)
    {
        $this->applicationType = $applicationType;
    }

    /**
     * @return mixed
     */
    public function getContacts(): array
    {
        return $this->contacts;
    }

    /**
     * @param mixed $contacts
     */
    public function setContacts(array $contacts)
    {
        $this->contacts = $contacts;
    }

    /**
     * @return mixed
     */
    public function getClientName(): string
    {
        return $this->clientName;
    }

    /**
     * @param mixed $clientName
     */
    public function setClientName(string $clientName)
    {
        $this->clientName = $clientName;
    }

    /**
     * @return mixed
     */
    public function getLogoUri(): string
    {
        return $this->logoUri;
    }

    /**
     * @param mixed $logoUri
     */
    public function setLogoUri(string $logoUri)
    {
        $this->logoUri = $logoUri;
    }

    /**
     * @return mixed
     */
    public function getClientUri(): string
    {
        return $this->clientUri;
    }

    /**
     * @param mixed $clientUri
     */
    public function setClientUri(string $clientUri)
    {
        $this->clientUri = $clientUri;
    }

    /**
     * @return mixed
     */
    public function getPolicyUri(): string
    {
        return $this->policyUri;
    }

    /**
     * @param mixed $policyUri
     */
    public function setPolicyUri(string $policyUri)
    {
        $this->policyUri = $policyUri;
    }

    /**
     * @return mixed
     */
    public function getTosUri(): string
    {
        return $this->tosUri;
    }

    /**
     * @param mixed $tosUri
     */
    public function setTosUri(string $tosUri)
    {
        $this->tosUri = $tosUri;
    }

    /**
     * @return mixed
     */
    public function getJwksUri(): string
    {
        return $this->jwksUri;
    }

    /**
     * @param mixed $jwksUri
     */
    public function setJwksUri(string $jwksUri)
    {
        $this->jwksUri = $jwksUri;
    }

    /**
     * @return mixed
     */
    public function getJwks(): JsonWebKeySet
    {
        return $this->jwks;
    }

    /**
     * @param mixed $jwks
     */
    public function setJwks(JsonWebKeySet $jwks)
    {
        $this->jwks = $jwks;
    }

    /**
     * @return mixed
     */
    public function getSectorIdentifierUri(): string
    {
        return $this->sectorIdentifierUri;
    }

    /**
     * @param mixed $sectorIdentifierUri
     */
    public function setSectorIdentifierUri(string $sectorIdentifierUri)
    {
        $this->sectorIdentifierUri = $sectorIdentifierUri;
    }

    /**
     * @return mixed
     */
    public function getSubjectType(): string
    {
        return $this->subjectType;
    }

    /**
     * @param mixed $subjectType
     */
    public function setSubjectType(string $subjectType)
    {
        $this->subjectType = $subjectType;
    }

    /**
     * @return mixed
     */
    public function getIdentityTokenSignedResponseAlgorithm(): string
    {
        return $this->identityTokenSignedResponseAlgorithm;
    }

    /**
     * @param mixed $identityTokenSignedResponseAlgorithm
     */
    public function setIdentityTokenSignedResponseAlgorithm(string $identityTokenSignedResponseAlgorithm)
    {
        $this->identityTokenSignedResponseAlgorithm = $identityTokenSignedResponseAlgorithm;
    }

    /**
     * @return mixed
     */
    public function getIdentityTokenEncryptedResponseAlgorithm(): string
    {
        return $this->identityTokenEncryptedResponseAlgorithm;
    }

    /**
     * @param mixed $identityTokenEncryptedResponseAlgorithm
     */
    public function setIdentityTokenEncryptedResponseAlgorithm(string $identityTokenEncryptedResponseAlgorithm)
    {
        $this->identityTokenEncryptedResponseAlgorithm = $identityTokenEncryptedResponseAlgorithm;
    }

    /**
     * @return mixed
     */
    public function getIdentityTokenEncryptedResponseEncryption()
    {
        return $this->identityTokenEncryptedResponseEncryption;
    }

    /**
     * @param mixed $identityTokenEncryptedResponseEncryption
     */
    public function setIdentityTokenEncryptedResponseEncryption($identityTokenEncryptedResponseEncryption)
    {
        $this->identityTokenEncryptedResponseEncryption = $identityTokenEncryptedResponseEncryption;
    }

    /**
     * @return mixed
     */
    public function getUserInfoSignedResponseAlgorithm(): string
    {
        return $this->userInfoSignedResponseAlgorithm;
    }

    /**
     * @param mixed $userInfoSignedResponseAlgorithm
     */
    public function setUserInfoSignedResponseAlgorithm(string $userInfoSignedResponseAlgorithm)
    {
        $this->userInfoSignedResponseAlgorithm = $userInfoSignedResponseAlgorithm;
    }

    /**
     * @return mixed
     */
    public function getUserInfoEncryptedResponseAlgorithm(): string
    {
        return $this->userInfoEncryptedResponseAlgorithm;
    }

    /**
     * @param mixed $userInfoEncryptedResponseAlgorithm
     */
    public function setUserInfoEncryptedResponseAlgorithm(string $userInfoEncryptedResponseAlgorithm)
    {
        $this->userInfoEncryptedResponseAlgorithm = $userInfoEncryptedResponseAlgorithm;
    }

    /**
     * @return mixed
     */
    public function getUserInfoEncryptedResponseEncryption(): string
    {
        return $this->userInfoEncryptedResponseEncryption;
    }

    /**
     * @param mixed $userInfoEncryptedResponseEncryption
     */
    public function setUserInfoEncryptedResponseEncryption(string $userInfoEncryptedResponseEncryption)
    {
        $this->userInfoEncryptedResponseEncryption = $userInfoEncryptedResponseEncryption;
    }

    /**
     * @return mixed
     */
    public function getRequestObjectSigningAlgorithm(): string
    {
        return $this->requestObjectSigningAlgorithm;
    }

    /**
     * @param mixed $requestObjectSigningAlgorithm
     */
    public function setRequestObjectSigningAlgorithm(string $requestObjectSigningAlgorithm)
    {
        $this->requestObjectSigningAlgorithm = $requestObjectSigningAlgorithm;
    }

    /**
     * @return mixed
     */
    public function getRequestObjectEncryptionAlgorithm(): string
    {
        return $this->requestObjectEncryptionAlgorithm;
    }

    /**
     * @param mixed $requestObjectEncryptionAlgorithm
     */
    public function setRequestObjectEncryptionAlgorithm(string $requestObjectEncryptionAlgorithm)
    {
        $this->requestObjectEncryptionAlgorithm = $requestObjectEncryptionAlgorithm;
    }

    /**
     * @return mixed
     */
    public function getRequestObjectEncryptionEncryption(): string
    {
        return $this->requestObjectEncryptionEncryption;
    }

    /**
     * @param mixed $requestObjectEncryptionEncryption
     */
    public function setRequestObjectEncryptionEncryption(string $requestObjectEncryptionEncryption)
    {
        $this->requestObjectEncryptionEncryption = $requestObjectEncryptionEncryption;
    }

    /**
     * @return mixed
     */
    public function getTokenEndpointAuthenticationMethod(): string
    {
        return $this->tokenEndpointAuthenticationMethod;
    }

    /**
     * @param mixed $tokenEndpointAuthenticationMethod
     */
    public function setTokenEndpointAuthenticationMethod(string $tokenEndpointAuthenticationMethod)
    {
        $this->tokenEndpointAuthenticationMethod = $tokenEndpointAuthenticationMethod;
    }

    /**
     * @return mixed
     */
    public function getTokenEndpointAuthenticationSigningAlgorithm(): string
    {
        return $this->tokenEndpointAuthenticationSigningAlgorithm;
    }

    /**
     * @param mixed $tokenEndpointAuthenticationSigningAlgorithm
     */
    public function setTokenEndpointAuthenticationSigningAlgorithm(string $tokenEndpointAuthenticationSigningAlgorithm)
    {
        $this->tokenEndpointAuthenticationSigningAlgorithm = $tokenEndpointAuthenticationSigningAlgorithm;
    }

    /**
     * @return mixed
     */
    public function getDefaultMaxAge(): int
    {
        return $this->defaultMaxAge;
    }

    /**
     * @param mixed $defaultMaxAge
     */
    public function setDefaultMaxAge(int $defaultMaxAge)
    {
        $this->defaultMaxAge = $defaultMaxAge;
    }

    /**
     * @return mixed
     */
    public function getRequireAuthenticationTime(): bool
    {
        return $this->requireAuthenticationTime;
    }

    /**
     * @param mixed $requireAuthenticationTime
     */
    public function setRequireAuthenticationTime(bool $requireAuthenticationTime)
    {
        $this->requireAuthenticationTime = $requireAuthenticationTime;
    }

    /**
     * @return mixed
     */
    public function getDefaultAcrValues(): array
    {
        return $this->defaultAcrValues;
    }

    /**
     * @param mixed $defaultAcrValues
     */
    public function setDefaultAcrValues(array $defaultAcrValues)
    {
        $this->defaultAcrValues = $defaultAcrValues;
    }

    /**
     * @return mixed
     */
    public function getInitiateLoginUri(): string
    {
        return $this->initiateLoginUri;
    }

    /**
     * @param mixed $initiateLoginUri
     */
    public function setInitiateLoginUri(string $initiateLoginUri)
    {
        $this->initiateLoginUri = $initiateLoginUri;
    }

    /**
     * @return mixed
     */
    public function getRequestUris(): array
    {
        return $this->requestUris;
    }

    /**
     * @param mixed $requestUris
     */
    public function setRequestUris(array $requestUris)
    {
        $this->requestUris = $requestUris;
    }

    /**
     * Converts the request to its json representation.
     * @return string
     */
    public function toJson(): string
    {
        $associative = array(
            ClientMetadataConstants::REDIRECT_URIS => $this->redirectUris,
            ClientMetadataConstants::RESPONSE_TYPES => $this->responseTypes,
            ClientMetadataConstants::GRANT_TYPES => $this->grantTypes,
            ClientMetadataConstants::APPLICATION_TYPE => $this->applicationType,
            ClientMetadataConstants::CONTACTS => $this->contacts,
            ClientMetadataConstants::CLIENT_NAME => $this->clientName,
            ClientMetadataConstants::LOGO_URI => $this->logoUri,
            ClientMetadataConstants::CLIENT_URI => $this->clientUri,
            ClientMetadataConstants::POLICY_URI => $this->policyUri,
            ClientMetadataConstants::TOS_URI => $this->tosUri,
            ClientMetadataConstants::JWKS_URI => $this->jwksUri,
            ClientMetadataConstants::JWKS => $this->jwks,
            ClientMetadataConstants::SECTOR_IDENTIFIER_URI => $this->sectorIdentifierUri,
            ClientMetadataConstants::SUBJECT_TYPE => $this->subjectType,
            ClientMetadataConstants::TOKEN_ENDPOINT_AUTHENTICATION_METHOD => $this->tokenEndpointAuthenticationMethod,
            ClientMetadataConstants::TOKEN_ENDPOINT_AUTHENTICATION_SIGNING_ALGORITHM => $this->tokenEndpointAuthenticationSigningAlgorithm,
            ClientMetadataConstants::DEFAULT_MAX_AGE => $this->defaultMaxAge,
            ClientMetadataConstants::REQUIRE_AUTHENTICATION_TIME => $this->requireAuthenticationTime,
            ClientMetadataConstants::DEFAULT_ACR_VALUES => $this->defaultAcrValues,
            ClientMetadataConstants::INITIATE_LOGIN_URIS => $this->initiateLoginUri,
            ClientMetadataConstants::REQUEST_URIS => $this->requestUris,
            ClientMetadataConstants::IDENTITY_TOKEN_SIGNED_RESPONSE_ALGORITHM => $this->identityTokenSignedResponseAlgorithm,
            ClientMetadataConstants::IDENTITY_TOKEN_ENCRYPTED_RESPONSE_ALGORITHM => $this->identityTokenEncryptedResponseAlgorithm,
            ClientMetadataConstants::IDENTITY_TOKEN_ENCRYPTED_RESPONSE_ENCRYPTION => $this->identityTokenEncryptedResponseEncryption,
            ClientMetadataConstants::USERINFO_SIGNED_RESPONSE_ALGORITHM => $this->userInfoSignedResponseAlgorithm,
            ClientMetadataConstants::USERINFO_ENCRYPTED_RESPONSE_ALGORITHM => $this->userInfoEncryptedResponseAlgorithm,
            ClientMetadataConstants::USERINFO_ENCRYPTED_RESPONSE_ENCRYPTION => $this->userInfoEncryptedResponseEncryption,
            ClientMetadataConstants::REQUEST_OBJECT_SIGNING_ALGORITHM => $this->requestObjectSigningAlgorithm,
            ClientMetadataConstants::REQUEST_OBJECT_ENCRYPTION_ALGORITHM => $this->requestObjectEncryptionAlgorithm,
            ClientMetadataConstants::REQUEST_OBJECT_ENCRYPTION_ENCRYPTION => $this->requestObjectEncryptionEncryption,
        );

        return json_encode($associative);
    }


}