<?php

namespace App\Http\Middleware;

use Closure;

class Fapesp
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $ip = \Request::getClientIp(true);

        if (substr($ip, 0, 4)==='192.' || substr($ip, 0, 4)==='127.' || substr($ip, 0, 3)==='10.') {
            return $next($request);
        }

        if (strpos($request->route()->getPrefix(), 'ajax')!==false) {
            return response('Not found', 404);
        } else {
            return abort(404);
        }
    }
}
