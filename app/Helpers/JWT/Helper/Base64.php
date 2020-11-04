<?php
namespace App\Helpers\JWT\Helper;

class Base64
{
    /**
     * Encode a string to a Base 64 string
     *
     * @param string $string
     *
     * @return string
     */
    public static function encode(string $string): string
    {
        return base64_encode($string);
    }

    /**
     * Decode a Base 64 string to a string
     *
     * @param string $base64String
     *
     * @return string
     */
    public static function decode(string $base64String): string
    {
        return base64_decode($base64String);
    }
}
