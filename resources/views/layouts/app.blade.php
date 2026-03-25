<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <!-- Codificación y configuración responsive básica -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Token CSRF de Laravel para proteger formularios y peticiones POST -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Título de la pestaña: toma el nombre de la app desde config/app.php -->
        <title>{{ config('app.name', 'Vinyls Vintage') }}</title>

        <!-- Fuentes externas (comentadas porque finalmente uso las de Tailwind) -->
        <!-- <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" /> -->

        <!-- Carga de assets compilados con Vite: Tailwind CSS y JavaScript de la app -->
        <!-- La plantilla carga Tailwind CSS -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Iconos de Ionicons para botones de Ver y Actualizar en el CRUD -->
        <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
        
    </head>

    <!-- Aplico fuente base y suavizado de tipografía con clases de Tailwind -->
    <body class="font-sans antialiased">

        <!-- Contenedor que ocupa toda la altura de la pantalla y define el fondo principal -->
        <div class="min-h-screen bg-beige-tostado">

            <!-- Incluyo la barra de navegación común a toda la aplicación -->
            @include('layouts.navigation')

            <!-- Encabezado de página: solo se muestra si la vista hija define $header -->
            <!-- Page Heading -->
            @isset($header)
                <header class="bg-beige-tostado shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        <!-- Aquí se inyecta el contenido del slot "header" -->
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Contenido principal de cada página (dashboard, catálogo, carrito, etc.)) -->
            <main class="p-6 bg-beige-tostado">
                <!-- Si la vista se basa en componentes Blade (como x-app-layout), se usa $slot -->
                @isset($slot)
                    {{ $slot }}
                @endisset

                <!-- Si la vista se construye con @extends y @section, se usa la sección "content" -->
                @yield('content')
            </main>

            <!-- Footer común para toda la aplicación -->
            @include('pie.footer')
        </div>
        
    </body>
</html>

<!--
¿Qué es este archivo app.blade.php dentro de la aplicación?
Este archivo es el **layout principal** de la aplicación: Es una plantilla base que define la estructura 
común de todas las páginas (head, navegación, contenido y footer) y evita repetir el mismo HTML en cada 
vista. Las vistas solo inyectan su contenido dentro de él.

En la zona del <head> cargo los assets compilados con Vite (`app.css` y `app.js`), donde está 
Tailwind y el JavaScript de la aplicación, y además incluyo Ionicons para usar iconos en los botones 
del CRUD.

El layout es compatible con las dos formas de trabajar en Blade: si la vista es un componente 
(`<x-app-layout>`), inyecto el contenido con `$header` y `$slot`, y si la vista extiende una plantilla 
con `@extends`, utilizo `@yield('content')` para mostrar su sección de contenido.

Gracias a esta estructura, cualquier página que quiera usar este diseño solo tiene que heredar del layout 
y proporcionar el contenido, manteniendo el código más limpio, reutilizable y fácil de mantener.

¿Para qué sirve la directiva @vite(['resources/css/app.css', 'resources/js/app.js'])?
Carga los assets compilados con Vite: el CSS (Tailwind y estilos propios) y el JavaScript de la aplicación, 
generados a partir de esos archivos de recursos.

¿Por qué incluyo <meta name="csrf-token" content="{{ csrf_token() }}">?
Para que Laravel pueda proteger formularios y peticiones AJAX frente a ataques CSRF, usando ese token en 
cada petición POST/PUT/DELETE.

¿Qué diferencia hay entre $slot y @yield('content') en este layout?
$slot se usa cuando la vista es un componente Blade (<x-app-layout>), mientras que @yield('content') se 
usa cuando la vista extiende una plantilla con @extends y define una sección @section('content').

¿Para qué sirve @include('layouts.navigation') y @include('pie.footer')?
Para reutilizar fragmentos de vista comunes (la barra de navegación y el pie) sin duplicar código en cada 
página.

¿Qué hace la clase min-h-screen bg-beige-tostado en el <div> principal?
min-h-screen hace que el contenedor ocupe al menos el alto completo de la ventana, y bg-beige-tostado 
aplica el color de fondo definido en Tailwind a toda la página.

¿Qué función tiene @isset($header) en el layout?
Comprueba si la vista ha definido el slot $header; si existe, muestra un encabezado con ese contenido, 
si no, simplemente no se pinta esa sección.

¿Por qué usas Ionicons y cómo se cargan aquí?
Los cargo con dos scripts (uno para navegadores modernos como módulo y otro de fallback) para poder usar 
iconos en los botones del CRUD (ver, editar, eliminar) en toda la app.

-->