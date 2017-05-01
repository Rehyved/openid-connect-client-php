<?php

namespace com\rehyved\openid\client\discovery;

class DiscoveryPolicy
{
    private $authority;

    private $requireHttps = true;
    private $allowHttpOnLoopback = true;
    private $loopbackAddresses = array("localhost", "127.0.0.1");
    private $validateIssuerName = true;
    private $validateEndpoints = true;
    private $endpointValidationExcludeList = array();
    private $additionalEndpointBaseAddresses = array();
    private $requireKeySet = true;

    /**
     * @return mixed
     */
    public function getAuthority()
    {
        return $this->authority;
    }

    /**
     * @param mixed $authority
     */
    public function setAuthority($authority)
    {
        $this->authority = $authority;
    }

    /**
     * @return bool
     */
    public function isRequireHttps()
    {
        return $this->requireHttps;
    }

    /**
     * @param bool $requireHttps
     */
    public function setRequireHttps($requireHttps)
    {
        $this->requireHttps = $requireHttps;
    }

    /**
     * @return bool
     */
    public function isAllowHttpOnLoopback()
    {
        return $this->allowHttpOnLoopback;
    }

    /**
     * @param bool $allowHttpOnLoopback
     */
    public function setAllowHttpOnLoopback($allowHttpOnLoopback)
    {
        $this->allowHttpOnLoopback = $allowHttpOnLoopback;
    }

    /**
     * @return array
     */
    public function getLoopbackAddresses()
    {
        return $this->loopbackAddresses;
    }

    /**
     * @param array $loopbackAddresses
     */
    public function setLoopbackAddresses($loopbackAddresses)
    {
        $this->loopbackAddresses = $loopbackAddresses;
    }

    /**
     * @return bool
     */
    public function isValidateIssuerName()
    {
        return $this->validateIssuerName;
    }

    /**
     * @param bool $validateIssuerName
     */
    public function setValidateIssuerName($validateIssuerName)
    {
        $this->validateIssuerName = $validateIssuerName;
    }

    /**
     * @return bool
     */
    public function isValidateEndpoints()
    {
        return $this->validateEndpoints;
    }

    /**
     * @param bool $validateEndpoints
     */
    public function setValidateEndpoints($validateEndpoints)
    {
        $this->validateEndpoints = $validateEndpoints;
    }

    /**
     * @return array
     */
    public function getEndpointValidationExcludeList()
    {
        return $this->endpointValidationExcludeList;
    }

    /**
     * @param array $endpointValidationExcludeList
     */
    public function setEndpointValidationExcludeList($endpointValidationExcludeList)
    {
        $this->endpointValidationExcludeList = $endpointValidationExcludeList;
    }

    /**
     * @return array
     */
    public function getAdditionalEndpointBaseAddresses()
    {
        return $this->additionalEndpointBaseAddresses;
    }

    /**
     * @param array $additionalEndpointBaseAddresses
     */
    public function setAdditionalEndpointBaseAddresses($additionalEndpointBaseAddresses)
    {
        $this->additionalEndpointBaseAddresses = $additionalEndpointBaseAddresses;
    }

    /**
     * @return bool
     */
    public function isRequireKeySet()
    {
        return $this->requireKeySet;
    }

    /**
     * @param bool $requireKeySet
     */
    public function setRequireKeySet($requireKeySet)
    {
        $this->requireKeySet = $requireKeySet;
    }


}