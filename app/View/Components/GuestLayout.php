<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

/**
 * Componente GuestLayout
 * - Representa la plantilla base para usuarios invitados (no logueados)
 * - Se puede usar en Blade como <x-guest-layout>
 */
class GuestLayout extends Component
{
    /**
     * Devuelve la vista que representa este componente
     * 
     * @return \Illuminate\View\View
     */
    public function render(): View
    {
        //Carga la vista resources/views/layouts/guest.blade.php
        return view('layouts.guest');
    }
}
