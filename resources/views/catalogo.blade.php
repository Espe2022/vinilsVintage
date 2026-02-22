<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo de Vinilos - Vinyls Vintage</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-crema-suave text-marron-chocolate"> 

    <!-- Barra superior -->
    <div class="bg-marron-chocolate text-beige-tostado py-3 px-6 flex justify-between items-center shadow-md">
        <h1 class="text-2xl font-bold text-beige-tostado">🎵 Vinyls Vintage</h1>
        <nav class="flex items-center space-x-6">
            <a href="/" class="text-beige-tostado font-medium hover:bg-oro-antiguo transition">Inicio</a>
            <a href="{{ route('login') }}" class="text-beige-tostado font-medium  hover:bg-oro-antiguo transition">Login</a>
            <a href="{{ route('register') }}" class="text-beige-tostado font-medium  hover:bg-oro-antiguo transition">Register</a>

            <!-- Mensaje de éxito -->   
            @if (session('success'))
                <div class="mb-4 p-4 rounded-md bg-oro-antiguo text-marron-chocolate font-semibold shadow-md">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Botón Ver Carrito (solo para usuarios autenticados) -->
            @auth
                <a href="{{ route('carrito.index') }}" 
                   class="bg-beige-tostado hover:bg-beige-tostado-hover text-marron-chocolate font-semibold px-4 py-2 rounded-lg shadow transition duration-200">
                    🛍️ Ver Carrito
                </a>
            @endauth
        </nav>
    </div>

    <!-- Catálogo -->
    <section class="max-w-7xl mx-auto p-10">
        <h2 class="text-4xl font-extrabold text-center mb-10">🎶 Catálogo de Vinilos</h2>

        <!-- Barra superior con buscador -->
        <div class="bg-marron-chocolate text-beige-tostado py-3 px-6 flex justify-start items-center shadow-md">
            
            <!-- Buscador utilizando un formulario-->
            <form action="{{ route('productos.buscar') }}" method="GET" class="relative">
                <input type="text" name="buscar"
                    placeholder="Buscar por categoría o nombre"
                    value="{{ request('buscar') }}"
                    class="px-4 py-2 pr-9 rounded-full bg-crema-suave text-marron-chocolate placeholder-beige-tostado 
                    border border-marron-chocolate focus:border-oro-antiguo focus:ring-2 focus:ring-oro-antiguo 
                    transition w-64">

                <!-- Icono lupa -->
                <button type="submit" 
                    class="absolute right-3 top-1/2 -translate-y-1/2 text-marron-chocolate">
                    🔍
                </button>
            </form>
        </div>

        {{-- Mostrar texto de búsqueda --}}
        @if(!empty($buscar))
            <h3 class="text-2xl text-center mb-6 text-oro-antiguo">
                Resultados para: <strong>{{ $buscar }}</strong>
            </h3>

            @if($productos->isEmpty())
                <p class="text-center text-marron-chocolate text-xl mb-10">
                    No se encontraron resultados para "{{ $buscar }}".
                </p>
            @endif
        @endif

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
            @foreach ($productos as $producto)
                <div class="bg-crema-suave rounded-2xl shadow hover:shadow-2xl transition transform hover:-translate-y-1 p-4 flex flex-col items-center">
                    <div class="overflow-hidden rounded-full w-64 h-64 mx-auto"> 
                       <!-- loading="lazy": hace que el navegador descargue la imagen sólo cuando está cerca de entrar en pantalla, lo que reduce mucho el tiempo de carga inicial si hay muchas tarjetas -->
                            <img src="{{ $producto->imagen ?? 'https://via.placeholder.com/300x300?text=Vinilo' }}" 
                            alt="{{ $producto->nombre }}"
                            loading="lazy" 
                            class="w-full h-full object-cover rounded-full transform hover:scale-105 transition duration-300 ease-in-out">
                    </div>

                    <!-- "whitespace-nowrap overflow-hidden": el nombre del disco debe entrar en 1 línea -->
                    <h3 class="text-xl font-semibold mt-3 text-center whitespace-nowrap overflow-hidden">{{ $producto->nombre }}</h3>
                    <p class="text-oro-antiguo text-center">{{ $producto->descripcion }}</p>
                    <p class="text-marron-chocolate font-bold mt-2 text-center">{{ number_format($producto->precio, 2) }} €</p>
              

                    <div class="mt-4 w-full flex flex-col items-center space-y-3">
                        @auth
                            <!-- Botón Añadir al carrito, solo visible si el usuario está autenticado -->
                            <form action="{{ route('carrito.agregar', $producto->id) }}" method="POST" class="mt-4 w-full text-center">
                                @csrf
                                <button type="submit" 
                                    class="bg-beige-tostado hover:bg-beige-tostado-hover text-marron-chocolate font-semibold py-2 px-4 rounded-full transition w-full max-w-xs">
                                    🛒 Añadir al carrito
                                </button>
                            </form>
                        @endauth
                    </div>

                    <!-- Muestra un aviso si no está autenticado -->
                    @guest
                        <p class="text-center text-beige-tostado mt-3">Inicia sesión para comprar</p>
                    @endguest
                
                </div>
            @endforeach
        </div>

        <!-- Sirve para mostrar la paginación (los botones “Anterior / Siguiente” o “1 2 3 …”) -->
        <div class="mt-10">
            @if(!empty($buscar))
                {{ $productos->appends(['buscar' => $buscar])->links() }}
            @else
                {{ $productos->links() }}
            @endif
        </div>
    </section>

    <!-- Pie de página reutilizable  -->
    @include('pie.footer')

</body>
</html> 

