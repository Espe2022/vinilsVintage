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

<!--
¿Qué papel tiene este archivo dentro de la aplicación?
Es el layout de invitado o autenticación: define la estructura común de las pantallas de login, registro y
recuperación de contraseña, reutilizando el mismo diseño para casi todas esas vistas.

¿Qué significa lang="{{ str_replace('_', '-', app()->getLocale()) }}" en la etiqueta <html>?
Toma el idioma actual de la aplicación (app()->getLocale(), por ejemplo es_ES) y lo transforma a formato 
estándar de HTML (es-ES), lo que mejora accesibilidad y SEO para contenido localizado.

¿Para qué sirve la metaetiqueta csrf-token en este contexto?
Expone el token CSRF de Laravel en el <head> para que el JavaScript de la aplicación pueda leerlo e 
incluirlo en peticiones AJAX, evitando ataques de falsificación de solicitudes.

¿Qué estás cargando con @vite(['resources/css/app.css', 'resources/js/app.js'])?
Carga los archivos de estilos y scripts que Vite ha compilado (incluyendo Tailwind y el JS de 
Breeze/Jetstream), para que este layout tenga la misma apariencia y comportamiento que el resto de la app.

¿Por qué usas un {{ $slot }} dentro del div central?
Porque este archivo es un componente Blade (por ejemplo <x-guest-layout>): el slot permite que cada vista 
de autenticación inserte su propio formulario dentro de la misma tarjeta visual, manteniendo el diseño 
unificado.

¿Qué consigues con las clases min-h-screen flex flex-col sm:justify-center items-center?
Hago que el contenedor ocupe al menos toda la altura de la pantalla y uso Flexbox para centrar el contenido 
horizontal y, en pantallas medianas hacia arriba, también centrarlo verticalmente.

¿Qué aporta el uso de la fuente externa Figtree?
Le doy una identidad visual más cuidada a la interfaz de autenticación y, al usar preconnect, optimizo 
ligeramente el tiempo de carga de la fuente desde el CDN.

El contenido de $slot es el formulario concreto de autenticación que se esté mostrando en ese momento: 
por ejemplo, el formulario de login, el de registro o el de restablecer contraseña, según la vista que 
use este layout como componente (<x-guest-layout>).

-->