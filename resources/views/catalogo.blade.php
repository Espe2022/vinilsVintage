<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo de Vinilos - Vinyls Vintage</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 text-gray-900 font-sans">

    <!-- Barra superior -->
    <div class="bg-black text-white py-3 px-6 flex justify-between items-center shadow-md">
        <h1 class="text-2xl font-bold">🎵 Vinyls Vintage</h1>
        <nav class="flex items-center space-x-6">
            <a href="/" class="text-white font-medium hover:text-gray-300 transition">Inicio</a>
            <a href="{{ route('login') }}" class="text-white font-medium hover:text-gray-300 transition">Login</a>
            <a href="{{ route('register') }}" class="text-white font-medium hover:text-gray-300 transition">Register</a>
        </nav>
    </div>

    <!-- Catálogo -->
    <section class="max-w-7xl mx-auto p-10">
        <h2 class="text-4xl font-extrabold text-center mb-10">🎶 Catálogo de Vinilos</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
            @foreach ($productos as $producto)
                <div class="bg-white rounded-2xl shadow hover:shadow-2xl transition transform hover:-translate-y-1 p-4">
                    <div class="overflow-hidden rounded-full w-64 h-64 mx-auto">
                        <img src="{{ $producto->imagen ?? 'https://via.placeholder.com/300x300?text=Vinilo' }}" 
                             alt="{{ $producto->nombre }}" 
                             class="w-full h-full object-cover rounded-full transform hover:scale-105 transition duration-300 ease-in-out">
                    </div>
                    <h3 class="text-xl font-semibold mt-3 text-center">{{ $producto->nombre }}</h3>
                    <p class="text-gray-600 text-center">{{ $producto->descripcion }}</p>
                    <p class="text-green-600 font-bold mt-2 text-center">${{ number_format($producto->precio, 2) }}</p>
                </div>
            @endforeach
        </div>

        <!-- Sirve para mostrar la paginación (los botones “Anterior / Siguiente” o “1 2 3 …”) -->
        <div class="mt-10">
            {{ $productos->links() }}
        </div>
    </section>

    <footer class="bg-black text-white text-center py-6 mt-10">
        <p class="text-sm">© 2025 Vinyls Vintage — Todos los derechos reservados.</p>
    </footer>

</body>
</html>