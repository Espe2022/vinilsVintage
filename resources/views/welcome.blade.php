<!DOCTYPE html>
<!-- Documento HTML5 con idioma dinámico desde Laravel -->
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- Configuración básica -->
    <meta charset="UTF-8">
    <!-- Responsive design: adapta la web a móviles -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
    <!-- Título de la página -->
    <title>Vinyls Vintage</title>

    {{-- 
        Carga de estilos (Tailwind) y JavaScript mediante Vite.
        Vite permite compilación rápida y optimización de recursos.
    --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- 
        Preload de imagen principal para mejorar el rendimiento.
        Se carga antes que el resto.
    -->
    <link rel="preload" as="image"
      href="{{ asset('images/AbbeyRoad-256.webp') }}"
      imagesrcset="{{ asset('images/AbbeyRoad-256.webp') }} 256w,
                    {{ asset('images/AbbeyRoad-512.webp') }} 512w,
                    {{ asset('images/AbbeyRoad-749.webp') }} 749w"
      imagesizes="(max-width: 640px) 256px,
                  (max-width: 1024px) 512px,
                  749px">
</head>

<!-- 
    Clases de Tailwind para colores personalizados del proyecto
-->
<body class="bg-crema-suave text-marron-chocolate">

    <!-- Barra superior con buscador -->
    <div class="bg-marron-chocolate text-beige-tostado py-3 px-6 flex justify-end items-center shadow-md">
        
        <!-- 
            Formulario de búsqueda:
            - Método GET para enviar parámetros en la URL
            - Ruta Laravel 'productos.buscar'
        -->
        <form action="{{ route('productos.buscar') }}" method="GET" class="relative">
            
            <!-- Campo de entrada -->
            <!-- 
                Estilos con Tailwind:
                - Bordes, colores personalizados
                - Efectos focus (UX)
            -->
            <input type="text" name="buscar"
                placeholder="Buscar por categoría o nombre"
                value="{{ request('buscar') }}"
                class="px-4 py-2 rounded-full bg-crema-suave text-marron-chocolate placeholder-beige-tostado 
                border border-marron-chocolate focus:border-oro-antiguo focus:ring-2 focus:ring-oro-antiguo 
                transition w-64">

            <!-- Botón con icono de lupa -->
            <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 text-marron-chocolate">
                🔍
            </button>
        </form>
    </div>

    <!-- Encabezado principal -->
    <header class="bg-marron-chocolate text-white text-center py-10 shadow-lg">

        <!-- Título -->
        <h1 class="text-6xl font-extrabold leading-tight tracking-tight text-beige-tostado">🎵 Vinyls Vintage</h1>
        
        <!-- Descripción -->
        <p class="text-lg mt-6 text-beige-tostado max-w-xl mx-auto">
            Los mejores discos de vinilo clásicos y modernos
        </p>

        <!-- Botón de acceso al catálogo -->
        <a href="http://127.0.0.1:8000/catalogo" class="mt-10 inline-block bg-beige-tostado hover:bg-oro-antiguo text-marron-chocolate px-8 py-3 rounded-xl font-semibold transition">
            Ver catálogo
        </a>
    </header>

<!-- Catálogo de destacados -->
<section class="max-w-7xl mx-auto p-10 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">

    <!-- Producto 1: Abbey Road (carga prioritaria) -->
    <div class="bg-crema-suave rounded-2xl shadow hover:shadow-2xl transition transform hover:-translate-y-1 p-4">
        
        <!-- Contenedor de imagen con animación -->
        <div class="w-64 h-64 rounded-full overflow-hidden mx-auto transform hover:scale-105 transition duration-300 ease-in-out bg-beige-tostado animate-pulse">
            
            <!-- 
                Uso de <picture> para imágenes responsive
                Se sirven diferentes tamaños según pantalla
            -->
            <picture>
                <source 
                    srcset="{{ asset('images/AbbeyRoad-256.webp') }} 256w,
                            {{ asset('images/AbbeyRoad-512.webp') }} 512w,
                            {{ asset('images/AbbeyRoad-749.webp') }} 749w"
                    sizes="(max-width: 640px) 256px, (max-width: 1024px) 512px, 749px"
                    type="image/webp">
                <img 
                    src="{{ asset('images/AbbeyRoad-256.webp') }}"
                    alt="Abbey Road"
                    class="w-full h-full object-cover relative"
                    loading="eager"
                    fetchpriority="high"
                    decoding="async">
            </picture>
        </div>

        <!-- Información del producto -->
        <h2 class="text-xl font-semibold mt-3 text-center">Abbey Road</h2>
        <p class="text-oro-antiguo text-center">The Beatles</p>
        <p class="text-marron-chocolate font-bold mt-2 text-center">39.99€</p>
    </div>

    <!-- Producto 2: Dark Side of the Moon (lazy loading para optimizar carga) -->
    <div class="bg-crema-suave rounded-2xl shadow hover:shadow-2xl transition transform hover:-translate-y-1 p-4">
        <div class="w-64 h-64 rounded-full overflow-hidden mx-auto transform hover:scale-105 transition duration-300 ease-in-out bg-beige-tostado animate-pulse">
            <picture>
                <source 
                    srcset="{{ asset('images/Dark_Side_of_the_Moon-256.webp') }} 256w,
                            {{ asset('images/Dark_Side_of_the_Moon-512.webp') }} 512w,
                            {{ asset('images/Dark_Side_of_the_Moon-749.webp') }} 749w"
                    sizes="(max-width: 640px) 256px, (max-width: 1024px) 512px, 749px"
                    type="image/webp">

                <!-- 
                    lazy: carga diferida (mejora rendimiento)
                -->
                <img 
                    src="{{ asset('images/Dark_Side_of_the_Moon-256.webp') }}"
                    alt="Dark Side of the Moon"
                    class="w-full h-full object-cover relative"
                    loading="lazy"
                    fetchpriority="low"
                    decoding="async">
            </picture>
        </div>
        <h2 class="text-xl font-semibold mt-3 text-center">Dark Side of the Moon</h2>
        <p class="text-oro-antiguo text-center">Pink Floyd</p>
        <p class="text-marron-chocolate font-bold mt-2 text-center">31.99€</p>
    </div>

    <!-- Producto 3: Prometo (lazy) -->
    <div class="bg-crema-suave rounded-2xl shadow hover:shadow-2xl transition transform hover:-translate-y-1 p-4">
        <div class="w-64 h-64 rounded-full overflow-hidden mx-auto transform hover:scale-105 transition duration-300 ease-in-out bg-beige-tostado animate-pulse">
            <picture>
                <source 
                    srcset="{{ asset('images/Prometo-256.webp') }} 256w,
                            {{ asset('images/Prometo-512.webp') }} 512w,
                            {{ asset('images/Prometo-749.webp') }} 749w"
                    sizes="(max-width: 640px) 256px, (max-width: 1024px) 512px, 749px"
                    type="image/webp">
                <img 
                    src="{{ asset('images/Prometo-256.webp') }}"
                    alt="Prometo"
                    class="w-full h-full object-cover relative"
                    loading="lazy"
                    fetchpriority="low"
                    decoding="async">
            </picture>
        </div>
        <h2 class="text-xl font-semibold mt-3 text-center">Prometo</h2>
        <p class="text-oro-antiguo text-center">Pablo Alborán</p>
        <p class="text-marron-chocolate font-bold mt-2 text-center">17.00€</p>
    </div>

    <!-- Producto 4: Pueblo Salvaje (lazy) -->
    <div class="bg-crema-suave rounded-2xl shadow hover:shadow-2xl transition transform hover:-translate-y-1 p-4">
        <div class="w-64 h-64 rounded-full overflow-hidden mx-auto transform hover:scale-105 transition duration-300 ease-in-out bg-beige-tostado animate-pulse">
            <picture>
                <source 
                    srcset="{{ asset('images/PuebloSalvaje-256.webp') }} 256w,
                            {{ asset('images/PuebloSalvaje-512.webp') }} 512w,
                            {{ asset('images/PuebloSalvaje-749.webp') }} 749w"
                    sizes="(max-width: 640px) 256px, (max-width: 1024px) 512px, 749px"
                    type="image/webp">
                <img 
                    src="{{ asset('images/PuebloSalvaje-256.webp') }}"
                    alt="Pueblo Salvaje"
                    class="w-full h-full object-cover relative"
                    loading="lazy"
                    fetchpriority="low"
                    decoding="async">
            </picture>
        </div>
        <h2 class="text-xl font-semibold mt-3 text-center">Pueblo salvaje</h2>
        <p class="text-oro-antiguo text-center">Manuel Carrasco</p>
        <p class="text-marron-chocolate font-bold mt-2 text-center">24.99€</p>
    </div>

</section>

<!-- 
    Inclusión de componente Blade (footer reutilizable)
-->
@include('pie.footer')

</body>
</html>



