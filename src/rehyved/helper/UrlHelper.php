<?php
namespace Rehyved\helper;

class UrlHelper {
	const HTTPS_SCHEME = "https";
	const HTTP_SCHEME = "http";

    /**
     * Returns the hostname of the provided url
     * @param string $url
     * @return string the hostname parsed from the provided url
     * @throws \InvalidArgumentException if the url is malformed
     */
	public static function getHostname(string $url){
        $url = UrlHelper::validateUrl($url);

        $hostname = parse_url($url, PHP_URL_HOST);
        if($hostname === false){
            throw new InvalidArgumentException("Could not determine hostname, url seems to be invalid: $url");
        }

        return $hostname;
    }

    /**
     * Returns the port of the provided url
     * @param string $url
     * @return string the port parsed from the provided url
     * @throws \InvalidArgumentException if the url is malformed
     */
    public static function getPort(string $url){
        $url = UrlHelper::validateUrl($url);

        $port = parse_url($url, PHP_URL_PORT);
        if($port === false){
            throw new InvalidArgumentException("Could not determine port, url seems to be invalid: $url");
        }

        return $port;
    }

    /**
     * Returns the hostname plus port of the provided url
     * @param string $url
     * @return string the hostname plus port parsed from the provided url
     * @throws \InvalidArgumentException if the url is malformed
     */
    public static function getAuthority(string $url){
        return UrlHelper::getHostname($url) . ":" . UrlHelper::getPort($url);
    }

    /**
     * Returns whether the provided url has the HTTPS scheme
     * @param string $url the url to check
     * @throws InvalidArgumentException if the url is malformed
     * @return boolean TRUE if has HTTPS scheme FALSE otherwise
     */
	public static function isHttps(string $url){
		$url = UrlHelper::validateUrl($url);
		
		$parsedUrl = parse_url($url);
		if($parsedUrl === false){
			throw new InvalidArgumentException("The provided url is not valid: $url");
		}
		
		return $parsedUrl["scheme"] === UrlHelper::HTTPS_SCHEME;
	}
	
	/**
	 * Returns whether the provided url has the HTTP scheme
	 * @param string $url the url to check
	 * @throws InvalidArgumentException if the url is malformed
	 * @return boolean TRUE if has HTTP scheme FALSE otherwise
	 */
	public static function isHttp(string $url){
		$url = UrlHelper::validateUrl($url);
		
		$parsedUrl = parse_url($url);
		if($parsedUrl === false){
			throw new InvalidArgumentException("The provided url is not valid: $url");
		}
		
		return $parsedUrl["scheme"] === UrlHelper::HTTP_SCHEME;
	}
	
	/**
	 * Checks if the given URL is valid.
	 * @param string $url the URL to check
	 * @return boolean TRUE if the URL is valid FALSE if it is not
	 */
	public static function isValidUrl(string $url){
		return filter_var($url, FILTER_VALIDATE_URL) !== false;
	}
	
	/**
	 * Validates the given URL and returns the URL if valid. If not valid this will throw an InvalidArgumentException
	 * @param string $url the URL to validate
	 * @throws InvalidArgumentException if the URL is not valid
	 * @return string the validated URL
	 */
	public static function validateUrl(string $url){
		if(!UrlHelper::isValidUrl($url)){
			throw new InvalidArgumentException("The provided url is not valid: $url");
		}
		
		return $url;
	}

    /**
     * Removes trailing slashes at the end of the provided url
     * @param string $url the url which needs to be trimmed
     * @return string the url without the trailing slash
     */
	public static function removeTrailingSlash(string $url){
	    if(!empty($url)) {
            return rtrim($url, '/');
        }
        return $url;
    }

    /**
     * Ensures trailing slashes at the end of the provided url
     * @param string $url the url on which the trailing slash should be ensured
     * @return string the url with a trailing slash
     */
    public static function ensureTrailingSlash(string $url){
        if(StringHelper::endsWith($url, '/') === false){
            return $url. '/';
        }
        return $url;
    }
}