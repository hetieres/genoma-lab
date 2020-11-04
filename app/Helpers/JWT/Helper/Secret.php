<?php
namespace App\Helpers\JWT\Helper;

use App\Helpers\JWT\Helper\Response;

class Secret
{
    /**
     * Validate a secret key string complies with the defined rules.
     *
     * @param string $secret
     * @return object
     */
    public static function validate(string $secret): object
    {
        if (strlen($secret) < 12) {
            return Response::return(true, 'O secret que você forneceu deve ter pelo menos 12 caracteres.');
        }

        if (!preg_match('/[0-9]/', $secret)) {
            return Response::return(true, 'O secret que você forneceu deve conter caracteres numéricos.');
        }

        if (!preg_match('/[A-Z]/', $secret)) {
            return Response::return(true, 'O secret que você forneceu deve conter letras maiúsculas.');
        }

        if (!preg_match('/[a-z]/', $secret)) {
            return Response::return(true, 'O secret que você forneceu deve conter letras minúsculas.');
        }

        if (!preg_match('/[\*&!@%\^#\$]/', $secret)) {
            return Response::return(true, 'O secret que você forneceu deve conter algum caracter especial (*&!@%^#$).');
        }

        return Response::return(false, 'Secret valido');
    }
}
