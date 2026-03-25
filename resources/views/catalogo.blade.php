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
                    <h3 class="text-xl font-semibold mt-3 text-center whitespace-nowrap overflow-hidden">{{ $producto->nombre }}</h3>
                    
                    <!-- Descripción -->
                    <p class="text-oro-antiguo text-center">{{ $producto->descripcion }}</p>
                    
                    <!-- Precio formateado -->
                    <p class="text-marron-chocolate font-bold mt-2 text-center">{{ number_format($producto->precio, 2) }} €</p>
              
                    <!-- Zona de acciones -->
                    <div class="mt-4 w-full flex flex-col items-center space-y-3">
                        @auth
                            
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


<!--
Esta vista está conectada al backend mediante Laravel, mostrando datos dinámicos con Blade, controlando 
acceso con autenticación y optimizando rendimiento con lazy loading y paginación.

¿Qué diferencia hay entre esta vista y la home?
Esta vista es dinámica porque muestra productos desde la base de datos usando @foreach, mientras que la 
anterior era estática con productos fijos.

¿Qué hace @foreach ($productos as $producto)?
Recorre la colección de productos enviada desde el controlador y genera una tarjeta HTML por cada producto.

¿De dónde viene $productos?
Viene del controlador, que probablemente obtiene los datos desde la base de datos usando un modelo de 
Laravel (Eloquent).

¿Qué es Eloquent?
Es el ORM de Laravel que permite interactuar con la base de datos usando objetos en lugar de SQL directo.

¿Qué hace @auth?
Muestra contenido solo si el usuario está autenticado. En este caso, permite ver el botón “Añadir al 
carrito”.

¿Y @guest?
Hace lo contrario: muestra contenido solo a usuarios no autenticados.

¿Por qué ocultas el botón de compra a usuarios no logueados?
Por control de acceso: solo usuarios autenticados pueden comprar, lo que evita acciones no autorizadas.

¿Qué hace @csrf?
Protege contra ataques CSRF (Cross-Site Request Forgery), asegurando que el formulario es legítimo.

¿Por qué el formulario de “añadir al carrito” usa POST?
Porque modifica el estado del sistema (añade un producto al carrito). Según REST, estas acciones deben 
usar POST.

¿Qué hace number_format($producto->precio, 2)?
Formatea el precio con 2 decimales para mostrarlo correctamente como moneda.

¿Qué pasa si un producto no tiene imagen?
Se muestra una imagen por defecto (placeholder) gracias al operador ??.

¿Qué hace esta línea?
$producto->imagen ?? 'https://via.placeholder.com/...'
Si $producto->imagen es null, se usa una imagen alternativa.

¿Qué problema solucionas con loading="lazy"?
Evita cargar todas las imágenes de golpe, mejorando el rendimiento cuando hay muchos productos.

¿Qué hace whitespace-nowrap overflow-hidden?
Evita que el texto del nombre se divida en varias líneas y oculta el exceso si es muy largo.

¿Cómo funciona el buscador?
    - Envía el valor por GET
    - El controlador filtra productos
    - Se devuelven los resultados filtrados a la vista

¿Qué hace este bloque?
@if(!empty($buscar))
Comprueba si hay una búsqueda activa para mostrar resultados o mensajes personalizados.

¿Qué ocurre si no hay resultados?
Se muestra un mensaje indicando que no se encontraron productos.

¿Qué hace appends(['buscar' => $buscar])?
Mantiene el parámetro de búsqueda al cambiar de página en la paginación.
         Esto es MUY importante para UX.

¿Qué hace links()?
Genera automáticamente la paginación (botones de páginas) usando Laravel.

¿Por qué usas paginación?
    - Mejora rendimiento
    - Evita cargar demasiados datos
    - Mejora experiencia de usuario

¿Qué ventajas tiene usar Blade?
    - Código más limpio
    - Integración con Laravel
    - Permite lógica sencilla en vistas
    - Reutilización con @include

¿Qué hace @include('pie.footer')?
Incluye un componente reutilizable (footer), evitando duplicar código.

¿Qué mejoras de seguridad hay en este código?
    - Uso de @csrf
    - Control de acceso con @auth
    - Evitar acciones sin login

¿Qué mejoras de UX destacarías?
    - Mensajes de éxito (session('success'))
    - Buscador persistente
    - Feedback visual (hover, animaciones)
    - Mensajes si no hay resultados

¿Cómo mejorarías este catálogo? 
    - Filtros por categoría/precio
    - Ordenar productos
    - Sistema de favoritos
    - Carga con AJAX (sin recargar)
-->