<?php

namespace Rehyved\helper;


class StringHelper
{
    public static function endsWith(string $haystack, string $needle, bool $caseSensitive = true){
        $haystackLength = strlen($haystack);
        $needleLength = strlen($needle);
        if ($needleLength > $haystackLength) return false;
        return substr_compare($haystack, $needle, $haystackLength - $needleLength, $needleLength, $caseSensitive) === 0;
    }

    public static function equals($first, $second, bool $caseSensitive = true){
        if($caseSensitive){
            return $first === $second;
        }else{
            return mb_strtolower($first) === mb_strtolower($second);
        }
    }

    public static function startsWith($haystack, $needle, bool $caseSensitive = true)
    {
        $haystackLength = strlen($haystack);
        $needleLength = strlen($needle);
        if ($needleLength > $haystackLength) return false;
        return substr_compare($haystack, $needle, 0, $needleLength, $caseSensitive) === 0;
    }

    public static function contains($haystack, $needle, bool $caseSensitive = true){
        if(!$caseSensitive){
            return stripos($haystack, $needle);
        }
        return strpos($haystack, $needle);
}
}