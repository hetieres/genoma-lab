<?php

namespace App\Http\Middleware;

use Closure;
use JWTHelper;
use App\Http\Middleware\EncryptCookies;
use Illuminate\Contracts\Encryption\Encrypter;

class AllowOnlyAjaxRequests
{
    /**
     * The encrypter implementation.
     *
     * @var \Illuminate\Contracts\Encryption\Encrypter
     */
    protected $encrypter;

    /**
     * Create a new middleware instance.
     *
     * @param  \Illuminate\Contracts\Encryption\Encrypter  $encrypter
     * @return void
     */
    public function __construct(Encrypter $encrypter)
    {
        $this->encrypter = $encrypter;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (isset($_COOKIE['XSRF-TOKEN']) && $this->tokensMatch($request) && $request->ajax()) {
            $jwt      = new JWTHelper;
            $token    = (isset($_COOKIE['JWT-TOKEN']) ? $_COOKIE['JWT-TOKEN'] : '');
            $validate = $jwt->validateJWT($token);

            return ($validate->error ? response($validate->message, 401) : $next($request));
        }

        return response('Unauthenticated', 401);
    }

    protected function getTokenFromRequest($request)
    {
        $token = $request->input('_token') ?: $request->header('X-CSRF-TOKEN');

        if (!$token && $header = $request->header('X-XSRF-TOKEN')) {
            $token = $this->encrypter->decrypt($header, static::serialized());
        }

        return $token;
    }

    protected function getTokenFromCookie()
    {
        $token = $_COOKIE['XSRF-TOKEN']?:'';

        if (trim($token)!=='') {
            $token = $this->encrypter->decrypt($token, static::serialized());
        }

        return $token;
    }

    protected function tokensMatch($request)
    {
        $tokenHeader = $this->getTokenFromRequest($request);
        $tokenCookie = $this->getTokenFromCookie();

        return is_string($tokenHeader) &&
               is_string($tokenCookie) &&
               hash_equals($tokenHeader, $tokenCookie);
    }

    /**
     * Determine if the cookie contents should be serialized.
     *
     * @return bool
     */
    public static function serialized()
    {
        return EncryptCookies::serialized('XSRF-TOKEN');
    }
}
