<?php


//Namespace donde se encuentra el middleware dentro del proyecto Laravel
namespace App\Http\Middleware;


//Importación de clases necesarias
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response; 

//Definición del middleware que controla acceso de administradores
class AdminMiddleware
{
    /**
     * Handle an incoming request.
     * Método principal del middleware.
     * Se ejecuta cada vez que una ruta protegida lo usa.
     * @param Request $request -> contiene la petición HTTP
     * @param Closure $next -> permite continuar con la siguiente acción (controlador)
     * 
     */
    public function handle(Request $request, Closure $next): Response
    {
        //Verifica si el usuario está logueado y si es administrador
        if (auth()->check() && auth()->user()->role === 'admin') {
            //Si cumple, deja pasar la petición al siguiente paso
            return $next($request);
        }

        //Si no es administrador, corta la ejecución y devuelve error 403 (prohibido el acceso)
        abort(403, 'No tienes permisos.');
    }
}
