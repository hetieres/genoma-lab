<?php
namespace App\Helpers\JWT\Helper;

class Hmac
{
    /**
     * Hash a string and always return the output as raw binary.
     *
     * @param string $hash
     * @param string $string
     * @param string $secret
     *
     * @return string
     */
    public static function hash(string $hash, string $string, string $secret): string
    {
        return hash_hmac($hash, $string, $secret, true);
    }
}