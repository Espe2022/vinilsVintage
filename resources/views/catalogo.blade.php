<!DOCTYPE html>
<html lang="es">
<head>
    <!-- Configuración básica del documento -->
    <meta charset="UTF-8">

    <!-- Configuración básica del documento -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Título de la página -->
    <title>Catálogo de Vinilos - Vinyls Vintage</title>

    {{-- 
        Carga de estilos (Tailwind CSS) y JavaScript usando Vite.
        Vite mejora el rendimiento y la compilación de recursos.
    --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<!-- 
    Clases de Tailwind personalizadas para colores del proyecto
-->
<body class="bg-crema-suave text-marron-chocolate"> 

    <!-- Barra superior de navegación -->
    <div class="bg-marron-chocolate text-beige-tostado py-3 px-6 flex justify-between items-center shadow-md">
        
        <!-- Título -->
        <h1 class="text-2xl font-bold text-beige-tostado">🎵 Vinyls Vintage</h1>

        <!-- Menú de navegación -->
        <nav class="flex items-center space-x-6">

            <!-- Enlace a la página principal -->
            <a href="/" class="text-beige-tostado font-medium hover:bg-oro-antiguo transition">Inicio</a>
            
            <!-- Rutas de autenticación -->
            <a href="{{ route('login') }}" class="text-beige-tostado font-medium  hover:bg-oro-antiguo transition">Login</a>
            <a href="{{ route('register') }}" class="text-beige-tostado font-medium  hover:bg-oro-antiguo transition">Register</a>

            <!-- 
                Mensaje flash de éxito:
                Se muestra cuando Laravel guarda un mensaje en sesión
            -->     
            @if (session('success'))
                <div class="mb-4 p-4 rounded-md bg-oro-antiguo text-marron-chocolate font-semibold shadow-md">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Botón Ver Carrito (solo visible para usuarios autenticados) -->
            @auth
                <a href="{{ route('carrito.index') }}" 
                   class="bg-beige-tostado hover:bg-beige-tostado-hover text-marron-chocolate font-semibold px-4 py-2 rounded-lg shadow transition duration-200">
                    🛍️ Ver Carrito
                </a>
            @endauth
        </nav>
    </div>

    <!-- Sección principal del catálogo -->
    <section class="max-w-7xl mx-auto p-10">

        <!-- Título -->
        <h2 class="text-4xl font-extrabold text-center mb-10">🎶 Catálogo de Vinilos</h2>

        <!-- Barra superior con buscador -->
        <div class="bg-marron-chocolate text-beige-tostado py-3 px-6 flex justify-start items-center shadow-md">
            
             <!-- 
                Formulario de búsqueda:
                - Método GET para enviar datos en la URL
                - Ruta Laravel para filtrar productos
            -->
            <form action="{{ route('productos.buscar') }}" method="GET" class="relative">

                <!-- Campo de texto -->
                <!-- Estilos con Tailwind -->
                <input type="text" name="buscar"
                    placeholder="Buscar por categoría o nombre"
                    value="{{ request('buscar') }}"
                    class="px-4 py-2 pr-9 rounded-full bg-crema-suave text-marron-chocolate placeholder-beige-tostado 
                    border border-marron-chocolate focus:border-oro-antiguo focus:ring-2 focus:ring-oro-antiguo 
                    transition w-64">

                <!-- Botón con icono lupa -->
                <button type="submit" 
                    class="absolute right-3 top-1/2 -translate-y-1/2 text-marron-chocolate">
                    🔍
                </button>
            </form>
        </div>

        {{-- Mostrar texto si hay búsqueda activa--}}
        @if(!empty($buscar))

            <!-- Indica que se está buscando -->
            <h3 class="text-2xl text-center mb-6 text-oro-antiguo">
                Resultados para: <strong>{{ $buscar }}</strong>
            </h3>

            <!-- Mensaje si no hay resultados -->
            @if($productos->isEmpty())
                <p class="text-center text-marron-chocolate text-xl mb-10">
                    No se encontraron resultados para "{{ $buscar }}".
                </p>
            @endif
        @endif

        <!-- 
            Grid responsive de productos:
            - 1 columna en móvil
            - hasta 4 en escritorio
        -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">

            <!-- Bucle que recorre los productos -->
            @foreach ($productos as $producto)

                <!-- Tarjeta de producto -->
                <div class="bg-crema-suave rounded-2xl shadow hover:shadow-2xl transition transform hover:-translate-y-1 p-4 flex flex-col items-center">
                    
                    <!-- Contenedor de imagen -->
                    <div class="overflow-hidden rounded-full w-64 h-64 mx-auto"> 

                        <!-- 
                            Imagen del producto:
                            - loading="lazy": mejora rendimiento
                            - fallback si no hay imagen
                        -->
                        <img src="{{ $producto->imagen ?? 'https://via.placeholder.com/300x300?text=Vinilo' }}" 
                        alt="{{ $producto->nombre }}"
                        loading="lazy" 
                        class="w-full h-full object-cover rounded-full transform hover:scale-105 transition duration-300 ease-in-out">
                    </div>

                    <!-- Nombre del producto -->
                    <!-- whitespace-nowrap evita saltos de línea -->
                    <h3 class="text-xl font-semibold mt-3 text-center text-marron-chocolate line-clamp-2 break-words min-h-[3.5rem]">{{ $producto->nombre }}</h3>
                    
                    <!-- Descripción -->
                    <p class="text-oro-antiguo text-center line-clamp-2">{{ $producto->descripcion }}</p>
                    
                    <!-- Precio formateado -->
                    <p class="text-marron-chocolate font-bold mt-2 text-center">{{ number_format($producto->precio, 2) }} €</p>
              
                    <!-- Zona de acciones -->
                    <div class="mt-4 w-full flex flex-col items-center space-y-3">
                        @auth
                            @if ($producto->stock > 0)
                                <!-- 
                                    Formulario para añadir producto al carrito:
                                    - Método POST porque modifica datos
                                    - Incluye protección CSRF
                                -->
                                <form action="{{ route('carrito.agregar', $producto->id) }}" method="POST" class="mt-4 w-full text-center">
                                    @csrf
                                    <button type="submit" 
                                        class="bg-beige-tostado hover:bg-beige-tostado-hover text-marron-chocolate font-semibold py-2 px-4 rounded-full transition w-full max-w-xs">
                                        🛒 Añadir al carrito
                                    </button>
                                </form>
                            @else
                                <button disabled
                                    class="bg-beige-tostado text-marron-chocolate font-semibold py-2 px-4 mt-4 rounded-full w-full max-w-xs cursor-not-allowed opacity-70">
                                    Sin stock
                                </button>
                            @endif
                        @endauth
                    </div>

                    <!-- Muestra un aviso si el usuario no está autenticado -->
                    @guest
                        <p class="text-center text-beige-tostado mt-3">Inicia sesión para comprar</p>
                    @endguest
                
                </div>
            @endforeach
        </div>

        <!-- 
            Paginación:
            - links() genera botones automáticamente
            - appends mantiene la búsqueda al cambiar de página
        -->
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


