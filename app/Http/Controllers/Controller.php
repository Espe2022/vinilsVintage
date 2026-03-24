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


/*
Este es el controlador base del que heredan todos los controladores de la aplicación. 
Permite centralizar lógica común y seguir una estructura organizada en el proyecto.

Es Abstracto porque no se usa directamente, sino que sirve como plantilla para otros controladores.

Mis controladores como CarritoController y CompraController extienden de esta clase, lo que permite 
mantener una estructura común en toda la aplicación.

Laravel sigue el patrón MVC, y este controlador base forma parte de la capa de controladores, encargada 
de gestionar la lógica entre el modelo y la vista.

*/