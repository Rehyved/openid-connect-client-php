<?php
/**
 * Created by PhpStorm.
 * User: mpwal
 * Date: 4/30/2017
 * Time: 12:48 AM
 */

namespace com\rehyved\helper;


class JsonParseException extends \Exception
{

    private $json;
    public function __construct($message, $code, $json)
    {
        parent::__construct($message, $code);
        $this->json = $json;
    }

    /**
     * @return \Throwable
     */
    public function getJson(): \Throwable
    {
        return $this->json;
    }


}