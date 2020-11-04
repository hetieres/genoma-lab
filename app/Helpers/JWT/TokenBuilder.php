<?php
namespace App\Helpers\JWT;

use Carbon\Carbon;
use App\Helpers\JWT\Helper\Secret;
use App\Helpers\JWT\Helper\DateTime;
use App\Helpers\JWT\Helper\Response;
use App\Helpers\JWT\Helper\Signature;
use App\Helpers\JWT\Helper\TokenException;
use App\Helpers\JWT\Helper\TokenEncodeDecode;

/**
 * Class that generates a JSON Web Token, uses HS256 to generate the signature
 *
 * @author Rob Waller <rdwaller1984@gmail.com>
 */
class TokenBuilder extends TokenAbstract
{
    /**
     * Header token type attribute
     *
     * @var string
     */
    private $type = 'JWT';

    /**
     * Secret string or integer for generating JWT Signature
     *
     * @var string / int
     */
    private $secret;

    /**
     * Payload expiration date time string
     *
     * @var Carbon
     */
    private $expiration;

    /**
     * Payload issuer attribute
     *
     * @var string
     */
    private $issuer;

    /**
     * Payload audience attribute
     *
     * @var string
     */
    private $audience;

    /**
     * Payload subject attribute
     *
     * @var string
     */
    private $subject;

    /**
     * Array for generating the JWT payload
     *
     * @var array
     */
    private $payload = [];

    /**
     * Return the JWT header type string
     *
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * Return the secret string for the JWT signature generation
     *
     * @return string
     */
    public function getSecret(): string
    {
        if (!empty($this->secret)) {
            return $this->secret;
        }

        throw new TokenException(
            'Token secret not set, please add a secret to increase security'
        );
    }

    /**
     * Check the expiration object is valid and return the JWT expiration
     * attribute as a Carbon object
     *
     * @return Carbon
     */
    public function getExpiration(): Carbon
    {
        if (!$this->hasOldExpiration()) {
            return $this->expiration;
        }

        throw new TokenException(
            'Token expiration date has already expired, please set a future expiration date'
        );
    }

    /**
     * Return the JWT issuer attribute string
     *
     * @return string
     */
    public function getIssuer(): string
    {
        return $this->issuer;
    }

    /**
     * Return the JWT audience attribute string
     *
     * @return string
     */
    public function getAudience(): string
    {
        return empty($this->audience) ? '' : $this->audience;
    }

    /**
     * Set the audience of the token
     *
     * @param string $audience
     */
    public function setAudience(string $audience)
    {
        $this->audience = $audience;
    }

    /**
     * Return the JWT subject attribute string
     *
     * @return string
     */
    public function getSubject(): string
    {
        return empty($this->subject) ? '' : $this->subject;
    }

    /**
     * Set the subject of the token
     *
     * @param string $subject
     */
    public function setSubject(string $subject)
    {
        $this->subject = $subject;
    }

    /**
     * Json encode and return the JWT Header
     *
     * @return string
     */
    public function getHeader(): string
    {
        return json_encode(['alg' => $this->getAlgorithm(), 'typ' => $this->getType()]);
    }

    /**
     * Json encode and return the JWT Payload
     *
     * @return string
     */
    public function getPayload(): string
    {
        if (!array_key_exists('iss', $this->payload)) {
            $this->payload = array_merge($this->payload, ['iss' => $this->getIssuer()]);
            $this->payload = array_merge($this->payload, ['exp' => $this->getExpiration()->getTimestamp()]);
            $this->payload = array_merge($this->payload, ['sub' => $this->getSubject()]);
            $this->payload = array_merge($this->payload, ['aud' => $this->getAudience()]);
        }

        return json_encode($this->payload);
    }

    /**
     * Generate and return the JWT signature object
     *
     * @return Signature
     */
    public function getSignature(): Signature
    {
        return new Signature($this->getHeader(), $this->getPayload(), $this->getSecret(), $this->getHash());
    }

    /**
     * Set the secret for the JWT Signature, return the Token Builder
     *
     * @param string $secret
     *
     * @return object
     */
    public function setSecret(string $secret): object
    {
        $validated = Secret::validate($secret);
        if($validated->error) return $validated;

        $this->secret = $secret;
        return Response::return(false, 'Secret adicionado com sucesso');
    }

    /**
     * Parse a date time string to a Carbon object to set the expiration for the
     * JWT Payload, return the Token Builder
     *
     * @param mixed $expiration
     *
     * @return object
     */
    public function setExpiration($expiration): object
    {
        $return = Response::return(false, 'Data de expiração criada com sucesso');

        if (is_numeric($expiration)) {
            $this->expiration = DateTime::createFromTimestamp((int) $expiration);
            return $return;
        }

        $this->expiration = DateTime::parse($expiration);
        return $return;
    }

    /**
     * Set the issuer for the JWT issuer, return the Token Builder
     *
     * @param string $issuer
     *
     * @return object
     */
    public function setIssuer(string $issuer): object
    {
        $this->issuer = $issuer;

        return Response::return(false, 'Emissor criado com sucesso');
    }

    /**
     * Add key value pair to payload array
     *
     * @param array $payload
     *
     * @return object
     */
    public function addPayload(array $payload): object
    {
        if (isset($payload['key']) && isset($payload['value'])) {
            $this->payload = array_merge($this->payload, [$payload['key'] => $payload['value']]);

            return Response::return(false, 'Payload adicionado com sucesso');
        }

        return Response::return(true, 'Falha ao adicionar o payload, formato errado! O array deve conter chave e valor (key e value)');
    }

    /**
     * Encode the header string and return it
     *
     * @return string
     */
    private function encodeHeader(): string
    {
        return TokenEncodeDecode::encode($this->getHeader());
    }

    /**
     * Check for payload, if it exists encode and return payload
     *
     * @return string
     */
    private function encodePayload(): string
    {
        if (!empty($this->issuer) && !empty($this->expiration)) {
            return TokenEncodeDecode::encode($this->getPayload());
        }

        throw new TokenException(
            'Token cannot be built please add a payload, including an issuer and an expiration.'
        );
    }

    /**
     * Build and return the JSON Web Token, then tear down / reset class
     *
     * @return object
     */
    public function build(): object
    {
        $jwt = $this->encodeHeader() . "." . $this->encodePayload() . "." . $this->getSignature()->get();
        $this->tearDown();

        return Response::return(false, 'Token gerado com sucesso', ['token' => $jwt]);
    }

    /**
     * Check that the expiration Carbon object is not an old date
     *
     * @return bool
     */
    private function hasOldExpiration(): bool
    {
        return DateTime::olderThan(DateTime::now(), DateTime::parse($this->expiration));
    }

    /**
     * This method resets the class state after the build method is called.
     */
    private function tearDown()
    {
        $this->payload    = [];
        $this->secret     = '';
        $this->expiration = new Carbon;
        $this->issuer     = '';
        $this->subject    = '';
        $this->audience   = '';
    }
}
