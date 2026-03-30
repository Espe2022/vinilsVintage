<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        {{-- Codificación y configuración responsive básica --}}
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        {{-- Token CSRF de Laravel para proteger formularios y peticiones POST --}}
        <meta name="csrf-token" content="{{ csrf_token() }}">

        {{-- Título de la pestaña: toma el nombre de la app desde config/app.php --}}
        <title>{{ config('app.name', 'Vinyls Vintage') }}</title>

        {{-- Fuentes externas (comentadas porque finalmente uso las de Tailwind) --}}
        <!-- <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" /> -->

        {{-- Carga de assets compilados con Vite: Tailwind CSS y JavaScript de la app --}}
        {{-- La plantilla carga Tailwind CSS --}}
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        {{-- Iconos de Ionicons para botones de Ver y Actualizar en el CRUD --}}
        <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
        
    </head>

    {{-- Aplico fuente base y suavizado de tipografía con clases de Tailwind --}}
    <body class="font-sans antialiased">

        {{-- Mensaje de éxito de creación de usuario --}}
        @if (session('success'))
            <div style=" margin: 16px; padding: 12px 16px; background-color: #f5efe3; color: #4a2c2a;
                border: 1px solid #c9a96b; border-left: 5px solid #b08d57; border-radius: 8px;
                box-shadow: 0 2px 6px rgba(74, 44, 42, 0.08);">
                {{ session('success') }}
            </div>
        @endif

        {{-- Contenedor que ocupa toda la altura de la pantalla y define el fondo principal --}}
        <div class="min-h-screen bg-beige-tostado">

            {{-- Incluyo la barra de navegación común a toda la aplicación --}}
            @include('layouts.navigation')

            {{-- Encabezado de página: solo se muestra si la vista hija define $header --}}
            <!-- Page Heading -->
            @isset($header)
                <header class="bg-beige-tostado shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{-- Aquí se inyecta el contenido del slot "header" --}}
                        {{ $header }}
                    </div>
                </header>
            @endisset

            {{-- Contenido principal de cada página (dashboard, catálogo, carrito, etc.) --}}
            <main class="p-6 bg-beige-tostado">
                {{-- Si la vista se basa en componentes Blade (como x-app-layout), se usa $slot --}}
                @isset($slot)
                    {{ $slot }}
                @endisset

                {{-- Si la vista se construye con @extends y @section, se usa la sección "content" --}}
                @yield('content')
            </main>

            {{-- Footer común para toda la aplicación --}}
            @include('pie.footer')
        </div>
        
    </body>
</html>

