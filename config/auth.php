<?php

    /*
    |--------------------------------------------------------------------------
    | Configuración de autenticación
    |--------------------------------------------------------------------------
    |
    | Este archivo define cómo funciona el sistema de autenticación en Laravel:
    | - Login de usuarios
    | - Recuperación de contraseñas
    | - Gestión de sesiones
    |
    */

return [
    
    /*
    |--------------------------------------------------------------------------
    | Configuración por defecto
    |--------------------------------------------------------------------------
    |
    | Define el "guard" y el sistema de recuperación de contraseñas por defecto.
    |
    */
    'defaults' => [
        //Tipo de autenticación (web usa sesiones)
        'guard' => env('AUTH_GUARD', 'web'),

        //Configuración de recuperación de contraseñas
        'passwords' => env('AUTH_PASSWORD_BROKER', 'users'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Guards (métodos de autenticación)
    |--------------------------------------------------------------------------
    |
    | Los guards definen cómo se autentican los usuarios.
    |
    | En este caso:
    | - "web" usa sesiones (login clásico con cookies)
    |
    */
    'guards' => [
        'web' => [
            'driver' => 'session',  //Autenticación basada en sesión
            'provider' => 'users',  //Usa el proveedor "users"
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Providers (proveedores de usuarios)
    |--------------------------------------------------------------------------
    |
    | Definen cómo se obtienen los usuarios desde la base de datos, usando el modelo User con Eloquent.
    |
    */
    'providers' => [
        'users' => [
            //Usa Eloquent (modelo User)
            'driver' => 'eloquent',

            //Modelo que representa la tabla de usuarios
            'model' => env('AUTH_MODEL', App\Models\User::class),
        ],

        /*
        | Alternativa (no usada):
        | Obtener usuarios directamente desde la base de datos
        */
        // 'users' => [
        //     'driver' => 'database',
        //     'table' => 'users',
        // ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Recuperación de contraseñas
    |--------------------------------------------------------------------------
    |
    | Configura el sistema de "reset password".
    |
    */
    'passwords' => [
        'users' => [
            'provider' => 'users',

            //Tabla donde se guardan los tokens de recuperación
            'table' => env('AUTH_PASSWORD_RESET_TOKEN_TABLE', 'password_reset_tokens'),

            //Tiempo de validez del token (en minutos)
            'expire' => 60,

            //Tiempo de espera entre solicitudes (seguridad)
            'throttle' => 60,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Timeout de confirmación de contraseña
    |--------------------------------------------------------------------------
    |
    | Tiempo (en segundos) antes de volver a pedir la contraseña
    | en acciones sensibles (ej: cambiar datos).
    |
    */
    'password_timeout' => env('AUTH_PASSWORD_TIMEOUT', 10800),

];

/*
Funcionamiento del login: Laravel verifica las credenciales, guarda la sesión 
del usuario autenticado y mantiene la sesión mediante cookies.
*/
