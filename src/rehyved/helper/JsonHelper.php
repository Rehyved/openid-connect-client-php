<?php

namespace Rehyved\helper;


class JsonHelper
{
    public static function tryParse($json)
    {
        $result = json_decode($json);
        $jsonErrorCode = json_last_error();
        if($jsonErrorCode === JSON_ERROR_NONE){
            return $result;
        }else{
            $jsonErrorMessage = json_last_error_msg();
            throw new JsonParseException($jsonErrorMessage, $jsonErrorCode, $json);
        }
    }
}