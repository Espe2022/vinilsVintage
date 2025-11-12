<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response; 

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        //Si el usuario está logueado y es administrador
        if (auth()->check() && auth()->user()->role === 'admin') {
            return $next($request);
        }

        //Si no es administrador, bloquea el acceso
        abort(403, 'No tienes permisos.');
    }
}
