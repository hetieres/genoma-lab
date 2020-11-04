<?php
namespace App\Helpers\JWT\Helper;

use Exception;

class TokenException extends Exception
{
    /**
     * Constructor for the Token Exception class
     *
     * @param string $message
     * @param int $code
     * @param string $previous
     */
    public function __construct(string $message, int $code = 0, $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
