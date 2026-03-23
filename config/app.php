<?php

/*
|--------------------------------------------------------------------------
| Configuración principal de la aplicación
|--------------------------------------------------------------------------
|
| Este archivo define los parámetros básicos de configuración de Laravel.
| Muchos de estos valores se obtienen del archivo .env, lo que permite
| cambiar la configuración sin modificar el código.
|
| El archivo .env es un archivo donde se guardan variables de entorno como 
| credenciales, URLs o configuración. No se sube al repositorio por seguridad.
|
*/

return [

    /*
    |--------------------------------------------------------------------------
    | Nombre de la aplicación
    |--------------------------------------------------------------------------
    |
    | Se utiliza en notificaciones, emails y elementos de la interfaz.
    | En este caso, el nombre de la tienda online.
    |
    */
    'name' => env('APP_NAME', 'Vinyls Vintage'),

    /*
    |--------------------------------------------------------------------------
    | Entorno de la aplicación
    |--------------------------------------------------------------------------
    |
    | Define si la aplicación está en desarrollo, pruebas o producción.
    |
    | Ejemplos:
    | - local → desarrollo
    | - production → entorno real
    |
    */
    'env' => env('APP_ENV', 'production'),

    /*
    |--------------------------------------------------------------------------
    | Modo debug
    |--------------------------------------------------------------------------
    |
    | Si está activado (true), muestra errores detallados.
    | Si está desactivado (false), muestra errores genéricos.
    |
    | IMPORTANTE:
    | - En desarrollo → true
    | - En producción → false (por seguridad)
    |
    */
    'debug' => (bool) env('APP_DEBUG', false),

    /*
    |--------------------------------------------------------------------------
    | URL de la aplicación
    |--------------------------------------------------------------------------
    |
    | URL base utilizada por Laravel para generar enlaces.
    |
    */
    'url' => env('APP_URL', 'http://localhost'),

     /*
    |--------------------------------------------------------------------------
    | Zona horaria
    |--------------------------------------------------------------------------
    |
    | Define la zona horaria usada en fechas.
    | Recomendado cambiar a:
    | 'Europe/Madrid' para tu proyecto.
    |
    */
    'timezone' => env('APP_TIMEZONE', 'UTC'),

     /*
    |--------------------------------------------------------------------------
    | Idioma de la aplicación
    |--------------------------------------------------------------------------
    |
    | Define el idioma por defecto del sistema.
    |
    */
    'locale' => env('APP_LOCALE', 'en'),

    /*
    | Idioma alternativo si no existe traducción
    */
    'fallback_locale' => env('APP_FALLBACK_LOCALE', 'en'),

    /*
    | Idioma para generar datos falsos (faker)
    */
    'faker_locale' => env('APP_FAKER_LOCALE', 'en_US'),

    /*
    |--------------------------------------------------------------------------
    | Configuración de encriptación
    |--------------------------------------------------------------------------
    |
    | Laravel usa esta clave para cifrar datos sensibles:
    | - Contraseñas
    | - Cookies
    | - Tokens
    |
    */
    'cipher' => 'AES-256-CBC',

    /*
    | Clave principal de la aplicación (MUY IMPORTANTE).
    | APP_KEY es la clave usada por Laravel para cifrar datos. 
    | Es fundamental para la seguridad de la aplicación.
    |
    */
    'key' => env('APP_KEY'),

    /*
    | Claves anteriores (para rotación de claves)
    */
    'previous_keys' => [
        ...array_filter(
            explode(',', env('APP_PREVIOUS_KEYS', ''))
        ),
    ],

    /*
    |--------------------------------------------------------------------------
    | Modo mantenimiento
    |--------------------------------------------------------------------------
    |
    | Permite poner la aplicación en mantenimiento.
    |
    | Ejemplo:
    | php artisan down
    |
    */
    'maintenance' => [
        'driver' => env('APP_MAINTENANCE_DRIVER', 'file'),
        'store' => env('APP_MAINTENANCE_STORE', 'database'),
    ],

];
