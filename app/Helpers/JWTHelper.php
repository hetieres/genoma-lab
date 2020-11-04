<?php
namespace App\Helpers;

use Carbon\Carbon;
use App\Helpers\JWT\TokenBuilder;
use App\Helpers\JWT\TokenValidator;
use App\Helpers\JWT\Helper\TokenException;

class JWTHelper {
    protected $payload;
    protected $token;
    protected $passKey;

    public function __construct()
    {
        $this->token   = '';
        $this->payload = [];
        $this->passKey = 'yu6&pNx8OPcexG#g';
    }

    public function setPayload(array $payload)
    {
        $this->payload = $payload;
    }

    public function addPayload($key, $value)
    {
        $this->payload[$key] = $value;
    }

    public function getJWT()
    {
        $this->generateToken();
        return $this->token;
    }

    public function validateJWT($token)
    {
        $validator       = new TokenValidator;

        $vStructure      = $validator->splitToken($token);
        if($vStructure->error) return $vStructure;

        $vDateExpiration = $validator->validateExpiration();
        if($vDateExpiration->error) return $vDateExpiration;

        $vSignature      = $validator->validateSignature($this->passKey);
        return $vSignature;
    }

    public function generateCookie($path = "/")
    {
        $token      = $this->getJWT();
        $expiration = time() + 86400; // 1 day - 86400 | 12 hours - 43200

        setcookie('JWT-TOKEN', $token, $expiration, $path);
    }

    public function deleteCookie($path = "/")
    {
        unset($_COOKIE['JWT-TOKEN']);
        setcookie('JWT-TOKEN', null, -1, $path);
    }

    private function generateToken()
    {
        $expiration  = Carbon::now()->addMonths(1)->toDateTimeString();
        $issuer      = (isset($_SERVER['HTTP_CLIENT_IP']) ? $_SERVER['HTTP_CLIENT_IP'] : (isset($_SERVER['HTTP_X_FORWARDE‌​D_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR']));

        $builder     = new TokenBuilder();
        $this->addPayloadBuild($builder);

        $vSecret     = $builder->setSecret($this->passKey);
        if($vSecret->error) throw new TokenException($vSecret->message);

        $vExpiration = $builder->setExpiration($expiration);
        if($vExpiration->error) throw new TokenException($vExpiration->message);

        $vIssuer     = $builder->setIssuer($issuer);
        if($vIssuer->error) throw new TokenException($vIssuer->message);

        $token       = $builder->build();
        if($token->error) throw new TokenException($token->message);

        $this->token = $token->data->token;
    }

    /**
     * Adiciona os dados do payload ao builder do JWT
     *
     * @param [class] $builder
     * @return void
     */
    private function addPayloadBuild($builder)
    {
        foreach ($this->payload as $key => $value) {
            $builder->addPayload(['key' => $key, 'value' => $value]);
        }
    }
}
