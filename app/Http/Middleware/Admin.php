<?php

namespace App\Http\Middleware;

use Closure;

class Admin
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
        if (auth()->user()->type === 'admin') {
            return $next($request);
        }

        return redirect()->route('dashboard')->withErrors(['Você não tem permissão para acessar essa página!']);
    }
}
