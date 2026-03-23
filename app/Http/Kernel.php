<?php

namespace App\Http;

//Kernel es la “central de middleware” de Laravel
use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * Middlewares globales
     * Se ejecutan en **todas las peticiones** (web, API, etc.)
     * 
     */
    protected $middleware = [
        \App\Http\Middleware\TrustHosts::class,  //Confía en hosts específicos
        \App\Http\Middleware\TrustProxies::class,           //Confía en proxies
        \Fruitcake\Cors\HandleCors::class,        //Control de CORS
        \App\Http\Middleware\PreventRequestsDuringMaintenance::class,   //Bloquea peticiones si app en mantenimiento
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class, //Limita tamaño de POST
        \App\Http\Middleware\TrimStrings::class,    //Elimina espacios al inicio/final de strings
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,     //Convierte "" a null
    ];

    /**
     * Grupos de middleware
     * Se aplican a rutas según el grupo (web / api)
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,  //Cifra cookies
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,    //Añade cookies a la respuesta
            \Illuminate\Session\Middleware\StartSession::class,    //Inicia sesión
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,   //Pasa errores a vistas
            \App\Http\Middleware\VerifyCsrfToken::class,     //Protección CSRF
            \Illuminate\Routing\Middleware\SubstituteBindings::class,   //Reemplaza bindings de rutas
        ],

        'api' => [
            'throttle:api', //Limita la cantidad de peticiones
            \Illuminate\Routing\Middleware\SubstituteBindings::class,   //Reemplaza bindings de rutas
        ],
    ];

    /**
     * Middlewares de rutas
     * Se aplican usando ->middleware('nombre') en rutas específicas
     */
    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,  //Solo usuarios logueados
        'admin' => \App\Http\Middleware\AdminMiddleware::class, //Solo administradores
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class, //Redirige si ya está logueado
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class, //Email verificado
    ];
}