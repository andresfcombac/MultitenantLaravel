<?php

namespace App\Http\Middleware;

use Closure;

class AuthSessionMiddleware
{
    public function handle($request, Closure $next)
    {
        if (! session()->has('usuario_id')) {
            return redirect('/login');
        }

        return $next($request);
    }
}
