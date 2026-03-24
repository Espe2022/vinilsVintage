<?php

use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Configuración de caché
|--------------------------------------------------------------------------
|
| Este archivo define cómo Laravel gestiona la caché de la aplicación.
| La caché permite almacenar datos temporalmente para mejorar el rendimiento
| y evitar consultas repetidas a la base de datos.
|
*/

return [

    /*
    |--------------------------------------------------------------------------
    | Driver de caché por defecto
    |--------------------------------------------------------------------------
    |
    | Define qué sistema de caché se utiliza por defecto.
    | En este caso: base de datos, aunque en producción se podría usar Redis por su mayor velocidad.
    |
    */
    'default' => env('CACHE_STORE', 'database'),

    /*
    |--------------------------------------------------------------------------
    | Stores de caché
    |--------------------------------------------------------------------------
    |
    | Aquí se definen los distintos sistemas de almacenamiento de caché.
    | Se pueden usar diferentes drivers según necesidades.
    |
    | Caché Es un sistema que guarda datos temporalmente para acceder a 
    | ellos más rápido sin tener que recalcularlos o consultarlos de nuevo.
    | Uso de caché: Para mejorar el rendimiento, por ejemplo almacenando listas de productos 
    | o consultas frecuentes y reducir carga en la base de datos.
    |
    | El uso de caché es clave para la escalabilidad de aplicaciones web, ya que reduce 
    | la carga del servidor y mejora la experiencia del usuario.
    |
    */
    'stores' => [

        /*
        | Caché en memoria (solo dura durante la ejecución)
        | Útil para testing
        */
        'array' => [
            'driver' => 'array',
            'serialize' => false,
        ],

        /*
        | Caché en base de datos
        | Guarda datos en una tabla (ej: "cache")
        */
        'database' => [
            'driver' => 'database',
            'connection' => env('DB_CACHE_CONNECTION'),
            'table' => env('DB_CACHE_TABLE', 'cache'),
            'lock_connection' => env('DB_CACHE_LOCK_CONNECTION'),
            'lock_table' => env('DB_CACHE_LOCK_TABLE'),
        ],

        /*
        | Caché en archivos
        | Guarda los datos en el sistema de archivos
        */
        'file' => [
            'driver' => 'file',
            'path' => storage_path('framework/cache/data'),
            'lock_path' => storage_path('framework/cache/data'),
        ],

        /*
        | Memcached (sistema de caché en memoria)
        | Más rápido, usado en producción
        */
        'memcached' => [
            'driver' => 'memcached',
            'persistent_id' => env('MEMCACHED_PERSISTENT_ID'),
            'sasl' => [
                env('MEMCACHED_USERNAME'),
                env('MEMCACHED_PASSWORD'),
            ],
            'options' => [
                // Memcached::OPT_CONNECT_TIMEOUT => 2000,
                //Configuración adicional
            ],
            'servers' => [
                [
                    'host' => env('MEMCACHED_HOST', '127.0.0.1'),
                    'port' => env('MEMCACHED_PORT', 11211),
                    'weight' => 100,
                ],
            ],
        ],

        /*
        | Redis (muy usado en aplicaciones grandes)
        | Cache en memoria muy rápida
        */
        'redis' => [
            'driver' => 'redis',
            'connection' => env('REDIS_CACHE_CONNECTION', 'cache'),
            'lock_connection' => env('REDIS_CACHE_LOCK_CONNECTION', 'default'),
        ],

        /*
        | DynamoDB (AWS)
        | Caché distribuida en la nube
        */
        'dynamodb' => [
            'driver' => 'dynamodb',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
            'table' => env('DYNAMODB_CACHE_TABLE', 'cache'),
            'endpoint' => env('DYNAMODB_ENDPOINT'),
        ],

        /*
        | Octane (alto rendimiento)
        */
        'octane' => [
            'driver' => 'octane',
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Prefijo de caché
    |--------------------------------------------------------------------------
    |
    | Se usa para evitar conflictos si varias aplicaciones comparten
    | el mismo sistema de caché.
    |
    */
    'prefix' => env('CACHE_PREFIX', Str::slug(env('APP_NAME', 'laravel'), '_').'_cache_'),

];
