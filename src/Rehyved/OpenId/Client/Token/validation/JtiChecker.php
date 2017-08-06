<?php

namespace Rehyved\OpenId\Client\Token\validation;


class JtiChecker extends \Jose\Checker\JtiChecker
{
    private $expectedJti;
    public function __construct($expectedJti)
    {
        $this->expectedJti = $expectedJti;
    }

    /**
     * @param string $jti
     *
     * @return bool
     */
    protected function isJtiValid($jti)
    {
        return $jti === $this->expectedJti;
    }
}

