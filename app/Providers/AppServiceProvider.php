<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

/**
 * AppServiceProvider
 * - Clase base de proveedores de servicios de la aplicación
 * - Aquí se pueden registrar y configurar servicios que Laravel usará
 */
class AppServiceProvider extends ServiceProvider
{
     /**
     * Registrar servicios de la aplicación
     * - Se ejecuta antes de que la app maneje peticiones
     */
    public function register(): void
    {
        //Aquí se pueden registrar bindings o servicios en el contenedor
        //Ejemplo: $this->app->bind(MiServicio::class, function(){ ... });
    }

    /**
     * Inicializar servicios de la aplicación
     * - Se ejecuta después de que todos los servicios han sido registrados
     */
    public function boot(): void
    {
        //Configura que la paginación use Tailwind CSS para los links
        Paginator::useTailwind();
    }
}
