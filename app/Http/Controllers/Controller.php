<?php

namespace App\Http\Controllers;

/*
|--------------------------------------------------------------------------
| Controlador base
|--------------------------------------------------------------------------
|
| Esta clase es el controlador base de la aplicación.
|
| Todos los controladores (como CarritoController o CompraController)
| heredan de esta clase.
|
| Sirve como punto común donde se pueden añadir funcionalidades
| compartidas para todos los controladores.
|
*/

abstract class Controller
{
     /*
    |--------------------------------------------------------------------------
    | Clase abstracta
    |--------------------------------------------------------------------------
    |
    | Se define como "abstract" porque no se puede instanciar directamente.
    | Solo sirve como clase base para que otros controladores la extiendan.
    |
    */

    /*
    |--------------------------------------------------------------------------
    | Uso en la aplicación
    |--------------------------------------------------------------------------
    |
    | Ejemplo:
    | class CarritoController extends Controller
    |
    | Esto permite compartir lógica común entre controladores.
    |
    */

    /*
    |--------------------------------------------------------------------------
    | Posibles usos
    |--------------------------------------------------------------------------
    |
    | Aquí se podrían añadir:
    | - Métodos comunes para todos los controladores
    | - Middleware global
    | - Funciones auxiliares reutilizables
    |
    | Actualmente está vacío porque Laravel ya gestiona muchas
    | funcionalidades automáticamente.
    |
    */
}


