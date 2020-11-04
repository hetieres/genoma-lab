<?php
namespace App\Helpers\JWT;

use stdClass;
use Carbon\Carbon;
use App\Helpers\JWT\Helper\DateTime;
use App\Helpers\JWT\Helper\Response;
use App\Helpers\JWT\Helper\Signature;
use App\Helpers\JWT\Helper\TokenEncodeDecode;
use App\Helpers\JWT\Helper\TokenException;

/**
 * Class that validates a JSON Web Token based on the HS256 signature and the
 * expiration date.
 *
 * @author Rob Waller <rdwaller1984@gmail.com>
 */
class TokenValidator extends TokenAbstract
{
    /**
     * The header string of the JSON Web Token
     *
     * @var string
     */
    private $header;

    /**
     * The payload string of the JSON Web Token
     *
     * @var string
     */
    private $payload;

    /**
     * The signature string of the JSON Web Token
     *
     * @var string
     */
    private $signature;

    /**
     * Check the JWT token string has a valid structre and it into its three
     * component parts, header, payload and signature
     *
     * @param string $tokenString
     *
     * @return TokenValidator
     */
    public function splitToken(string $tokenString): object
    {
        $tokenParts = explode('.', $tokenString);

        if (count($tokenParts) === 3) {
            $this->header    = $tokenParts[0];
            $this->payload   = $tokenParts[1];
            $this->signature = $tokenParts[2];

            return Response::return(false, 'Estrutura do token válida');
        }

        return Response::return(true, 'A estrutura do token está inválida, assegure-se da existência de 3 strings separadas por pontos!');
    }

    /**
     * Validate that the JWT expiration date is valid and has not expired.
     *
     * @return TokenValidator
     */
    public function validateExpiration(): object
    {
        if (
            DateTime::olderThan(
                DateTime::now(),
                $this->parseExpiration($this->getExpiration())
            )
        ) {
            return Response::return(true, 'O token está expirado!');
        }

        return Response::return(false, 'Token dentro do tempo de validade');
    }

    /**
     * Parse the expiration string or integer into a Carbon object
     *
     * @param mixed $expiration
     * @return Carbon
     */
    private function parseExpiration($expiration): Carbon
    {
        return is_numeric($this->getExpiration()) ?
            DateTime::createFromTimestamp($expiration) :
            DateTime::parse($expiration);
    }

    /**
     * Generate a new Signature object based on the header, payload and secret
     * then check that the signature matches the token signature
     *
     * @param string $secret
     *
     * @return bool
     */
    public function validateSignature(string $secret): object
    {
        $signature = new Signature($this->getHeader(), $this->getPayload(), $secret, $this->getHash());

        if (hash_equals($signature->get(), $this->signature)) {
            return Response::return(false, 'Token validado com sucesso');
        }

        return Response::return(true, 'Token informado inválido!', ['Input' => $this->signature, 'Generated' => $signature->get()]);
    }

    /**
     * Json decode the JWT payload and return the expiration attribute
     *
     * @return string
     */
    public function getExpiration(): string
    {
        $payload = json_decode($this->getPayload());

        if (isset($payload->exp)) {
            return  $payload->exp;
        }

        throw new TokenException(
            'Objeto payload inválido, nenhum parâmetro de expiração setado'
        );
    }

    /**
     * Base 64 decode and return the JWT payload
     *
     * @return string
     */
    public function getPayload(): string
    {
        return TokenEncodeDecode::decode($this->payload);
    }

    /**
     * Base 64 decode and return the JWT header
     *
     * @return string
     */
    public function getHeader(): string
    {
        return TokenEncodeDecode::decode($this->header);
    }

    /**
     * Return payload but decode JSON string to stdClass first
     *
     * @return stdClass
     */
    public function getPayloadDecodeJson(): stdClass
    {
        return json_decode($this->getPayload());
    }

    /**
     * Return header but decode JSON string to stdClass first
     *
     * @return stdClass
     */
    public function getHeaderDecodeJson(): stdClass
    {
        return json_decode($this->getHeader());
    }
}
