<?php

/*
|--------------------------------------------------------------------------
| Service Providers de la aplicación
|--------------------------------------------------------------------------
|
| Este archivo define los proveedores de servicios propios de la aplicación.
|
| A diferencia de otros archivos donde Laravel registra automáticamente
| los providers de paquetes externos, aquí se registran los providers
| personalizados del proyecto.
|
*/
return [
      /*
    | AppServiceProvider
    |-------------------
    |
    | Es el proveedor principal de la aplicación.
    | Aquí se pueden registrar configuraciones globales, servicios propios
    | o lógica que se ejecuta al iniciar Laravel.
    |
    | Ejemplos de uso:
    | - Configurar variables globales
    | - Registrar servicios personalizados
    | - Modificar comportamiento del framework
    |
    */
    App\Providers\AppServiceProvider::class,
];
