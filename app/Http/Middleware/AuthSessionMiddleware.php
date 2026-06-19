<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthSessionMiddleware
{
    public function handle($request, Closure $next)
    {
        if (!session()->has('usuario_id')) {
            return redirect('/login');
        }

        return $next($request);
    }
}
