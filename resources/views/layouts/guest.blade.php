<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <!-- Codificación del documento en UTF‑8 -->
        <meta charset="utf-8">
        <!-- Hace la página responsive, ajustando el ancho al dispositivo -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Token CSRF de Laravel para proteger formularios y peticiones POST/AJAX -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Título de la pestaña del navegador. Por defecto usa "Vinyls Vintage" -->
        <title>{{ config('app.name', 'Vinyls Vintage') }}</title>

        <!-- Fuentes -->
        <!-- Preconexión al servidor de fuentes para mejorar el rendimiento -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <!-- Carga la familia de fuentes "Figtree" con varios pesos -->
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts y estilos de la app compilados con Vite (incluye Tailwind CSS) -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>

    <!-- Aplico fuente sans, color de fondo y color de texto globales con Tailwind -->
    <body class="font-sans bg-beige-tostado text-marron-chocolate antialiased">

        <!-- Contenedor que ocupa como mínimo toda la altura de la pantalla -->
        <!-- flex + flex-col centra verticalmente el contenido en pantallas grandes -->
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
            <div>
                <!-- Enlace al inicio con el logotipo de la aplicación -->
                <a href="/">
                    <!-- Componente Blade que dibuja el logo SVG con tamaño y color personalizados -->
                    <x-application-logo class="w-20 h-20 fill-current text-marron-chocolate" />
                </a>
            </div>

            <!-- Tarjeta central donde se muestra el contenido de autenticación (login/registro/reset...) -->
            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-beige-tostado text-marron-chocolate shadow-marron overflow-hidden sm:rounded-lg">
                <!-- Slot principal del componente: aquí se inyecta el formulario concreto -->
                {{ $slot }}
            </div>
        </div>
    </body>
</html>


