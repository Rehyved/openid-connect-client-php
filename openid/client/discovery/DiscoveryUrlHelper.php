<?php

namespace com\rehyved\openid\client\discovery;


use com\rehyved\helper\UrlHelper;

class DiscoveryUrlHelper
{
    public static function isSecureScheme(string $url, DiscoveryPolicy $policy)
    {
        if($policy->isRequireHttps()){
            if($policy->isAllowHttpOnLoopback()){
                $hostname = UrlHelper::getHostname($url);

                foreach($policy->getLoopbackAddresses() as $loopbackAddress){
                    if(stripos($hostname, $loopbackAddress) !== false){
                        return true;
                    }
                }
            }

            return UrlHelper::isHttps($url);
        }

        return true;
    }

    public static function isValidScheme($url)
    {
        return UrlHelper::isHttps($url) || UrlHelper::isHttp($url);
    }
}