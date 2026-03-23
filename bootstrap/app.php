<?php

/*
|--------------------------------------------------------------------------
| Bootstrap de la aplicación
|--------------------------------------------------------------------------
|
| Este archivo se encarga de configurar y crear la instancia principal
| de la aplicación Laravel (aquí se configura el arranque de la aplicación).
|
| Aquí se definen:
| - Rutas
| - Middleware
| - Manejo de excepciones
|
| Es uno de los primeros archivos que se ejecutan al iniciar el sistema.
|
*/
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

//Se crea y configura la aplicación indicando la ruta base del proyecto
return Application::configure(basePath: dirname(__DIR__))

    // ================================
    // CONFIGURACIÓN DE RUTAS
    // ================================
    ->withRouting(

        //Rutas web (interfaz de usuario, tienda online, etc.)
        web: __DIR__.'/../routes/web.php',

        //Rutas de consola (comandos Artisan personalizados)
        commands: __DIR__.'/../routes/console.php',


        //Ruta de comprobación de estado (health check)
        //Se usa para verificar que la aplicación está activa
        health: '/up',
    )

    // ================================
    // CONFIGURACIÓN DE MIDDLEWARE
    // ================================
    ->withMiddleware(function (Middleware $middleware) {
        /*
        | Aquí se pueden registrar middlewares globales o personalizados.
        |
        | Los middlewares permiten filtrar peticiones HTTP, por ejemplo:
        | - Autenticación de usuarios
        | - Protección CSRF
        | - Control de acceso (roles)
        |
        | En este caso está vacío porque Laravel ya incluye
        | una configuración por defecto.
        */
    })

    // ================================
    // MANEJO DE EXCEPCIONES
    // ================================
    ->withExceptions(function (Exceptions $exceptions) {
        /*
        | Aquí se pueden definir cómo manejar errores o excepciones.
        |
        | Ejemplos:
        | - Mostrar páginas personalizadas (404, 500)
        | - Registrar errores en logs
        |
        | Actualmente se usa la configuración por defecto de Laravel.
        */
    })
    
    // ================================
    // CREACIÓN DE LA APLICACIÓN
    // ================================
    ->create();



/*
|--------------------------------------------------------------------------
| RESUMEN
|--------------------------------------------------------------------------
|
| Este archivo:
| - Inicializa Laravel
| - Configura rutas, middleware y errores
| - Devuelve la aplicación lista para ejecutarse
|
*/