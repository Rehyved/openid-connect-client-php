<?php

namespace com\rehyved\openid\client\jwk;


use com\rehyved\helper\JsonHelper;

/**
 * Contains a collection of JsonWebKey that can be populated from a json string.
 */
class JsonWebKeySet
{
    private $keys;

    /**
     * Initializes an new instance of <see cref="JsonWebKeySet"/> from a json string.
     * @param $json a json string containing values to parse.
     */
    public function __construct($json)
    {
        if (empty($json)) {
            throw new \InvalidArgumentException("json was null or empty");
        }

        $jwebKeys = JsonHelper::tryParse($json);
        
        $this->keys = JsonWebKeySet::parseJsonWebKeys($jwebKeys->keys);
    }

    private static function parseJsonWebKeys(array $keys) : array {
        $jsonWebKeys = array();
        foreach($keys as $key){
            $jsonWebKeys[] = new JsonWebKey($key);
        }

        return $jsonWebKeys;
    }

    /**
     * Gets the array of JsonWebKey
     * @return mixed
     */
    public function getKeys()
    {
        return $this->keys;
    }
}