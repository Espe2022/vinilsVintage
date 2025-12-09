<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vinyls Vintage</title>

    {{-- Carga Tailwind y JS con Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-crema-suave text-marron-chocolate">
    <!-- Barra superior con buscador -->
    <div class="bg-marron-chocolate text-beige-tostado py-3 px-6 flex justify-end items-center shadow-md">
        
        <!-- Buscador utilizando un formulario-->
        <form action="{{ route('productos.buscar') }}" method="GET" class="relative">
            <input type="text" name="buscar"
                placeholder="Buscar por categoría o nombre"
                value="{{ request('buscar') }}"
                class="px-4 py-2 rounded-full bg-crema-suave text-marron-chocolate placeholder-beige-tostado 
                border border-marron-chocolate focus:border-oro-antiguo focus:ring-2 focus:ring-oro-antiguo 
                transition w-64">

            <!-- Icono lupa -->
            <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 text-marron-chocolate">
                🔍
            </button>
        </form>
    </div>

    <!-- Encabezado -->
    <header class="bg-marron-chocolate text-white text-center py-10 shadow-lg">
        <h1 class="text-6xl font-extrabold leading-tight tracking-tight text-beige-tostado">🎵 Vinyls Vintage</h1>
        <p class="text-lg mt-6 text-beige-tostado max-w-xl mx-auto">
            Los mejores discos de vinilo clásicos y modernos
        </p>

        <a href="http://127.0.0.1:8000/catalogo" class="mt-10 inline-block bg-beige-tostado hover:bg-oro-antiguo text-black px-8 py-3 rounded-xl font-semibold transition">
            Ver catálogo
        </a>
    </header>

<!-- Catálogo de destacados -->
<section class="max-w-7xl mx-auto p-10 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">

    <!-- Producto 1 -->
    <div class="bg-crema-suave rounded-2xl shadow hover:shadow-2xl transition transform hover:-translate-y-1 p-4">
        <div class="overflow-hidden rounded-full w-64 h-64 mx-auto">
            <img src="https://upload.wikimedia.org/wikipedia/en/4/42/Beatles_-_Abbey_Road.jpg" alt="Abbey Road" class="w-full h-full object-cover rounded-full transform hover:scale-105 transition duration-300 ease-in-out">
        </div>
        <h2 class="text-xl font-semibold mt-3 text-center">Abbey Road</h2>
        <p class="text-oro-antiguo text-center">The Beatles</p>
        <p class="text-marron-chocolate font-bold mt-2 text-center">$39.99</p>
    </div>

    <!-- Producto 2 -->
    <div class="bg-crema-suave rounded-2xl shadow hover:shadow-2xl transition transform hover:-translate-y-1 p-4">
        <div class="overflow-hidden rounded-full w-64 h-64 mx-auto">
            <img src="https://upload.wikimedia.org/wikipedia/en/3/3b/Dark_Side_of_the_Moon.png" alt="Dark Side of the Moon" class="w-full h-64 object-cover rounded-xl transform hover:scale-105 transition duration-300 ease-in-out">
        </div>
        <h2 class="text-xl font-semibold mt-3 text-center">Dark Side of the Moon</h2>
        <p class="text-oro-antiguo text-center">Pink Floyd</p>
        <p class="text-marron-chocolate font-bold mt-2 text-center">$42.50</p>
    </div>

    <!-- Producto 3 -->
    <div class="bg-crema-suave rounded-2xl shadow hover:shadow-2xl transition transform hover:-translate-y-1 p-4">
        <div class="overflow-hidden rounded-full w-64 h-64 mx-auto">
            <img src="https://m.media-amazon.com/images/I/61rgentIYZL._SX425_.jpg" alt="Prometo" class="w-full h-64 object-cover rounded-xl transform hover:scale-105 transition duration-300 ease-in-out">
        </div>
        <h2 class="text-xl font-semibold mt-3 text-center">Prometo</h2>
        <p class="text-oro-antiguo text-center">Pablo Alborán</p>
        <p class="text-marron-chocolate font-bold mt-2 text-center">$35.00</p>
    </div>

    <!-- Producto 4 -->
    <div class="bg-crema-suave rounded-2xl shadow hover:shadow-2xl transition transform hover:-translate-y-1 p-4">
        <div class="overflow-hidden rounded-full w-64 h-64 mx-auto">
            <img src="https://www.lahiguera.net/musicalia/artistas/manuel_carrasco/disco/13970/tema/32125/portada-p.jpg" alt="Pueblo salvaje" class="w-full h-64 object-cover rounded-xl transform hover:scale-105 transition duration-300 ease-in-out">
        </div>
        <h2 class="text-xl font-semibold mt-3 text-center">Pueblo salvaje</h2>
        <p class="text-oro-antiguo text-center">Manuel Carrasco</p>
        <p class="text-marron-chocolate font-bold mt-2 text-center">$24.99</p>
    </div>

</section>

<!-- Incluir Pie de página -->
@include('pie.footer')

</body>
</html>