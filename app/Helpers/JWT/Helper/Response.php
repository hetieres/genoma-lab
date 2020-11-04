<?php
namespace App\Helpers\JWT\Helper;

class Response
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
    public static function return(bool $error, string $message, array $data = null): object
    {
        $return = (object) [
            'error'   => $error,
            'message' => $message,
            'data'    => (object) $data
        ];

        return $return;
    }
}