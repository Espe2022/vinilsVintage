<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

/**
 * Componente AppLayout
 * - Representa la plantilla base de la aplicación
 * - Se puede usar en Blade como <x-app-layout>
 */
class AppLayout extends Component
{
    /**
     * Devuelve la vista que representa este componente
     * 
     * @return \Illuminate\View\View
     */
    public function render(): View
    {
        //Carga la vista resources/views/layouts/app.blade.php
        return view('layouts.app');
    }
}
