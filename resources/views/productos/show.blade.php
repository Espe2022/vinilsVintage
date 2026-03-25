<x-app-layout>
    <!-- Slot para el encabezado de la página -->
    <x-slot name="header">
        <!-- Título de la página -->
        <h2 class="font-semibold text-xl text-marron-chocolate bg-oro-antiguo leading-tight">
            Detalle del Producto
        </h2>
    </x-slot>

    <!-- Contenedor principal de la página -->
    <div class="py-12 bg-beige-crema">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-beige-crema overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8 text-marron-chocolate">

                    <!-- Mostrar el nombre del producto -->
                    <h4 class="font-semibold text-2xl">Nombre del Producto: {{ $producto->nombre }}</h4>
                    
                    <!-- Mostrar la descripción del producto -->
                    <p class="font-light text-lg">{{ $producto->descripcion }}</p>

                    <!-- Mostrar el precio del producto -->
                    <p class="text-lg">Precio: {{ $producto->precio }} €.</p>
               
                    <!-- Mostrar el stock con mensaje -->
                    @if($producto->stock > 0)
                        <p class="text-marron-chocolate font-medium mb-4">Stock disponible: {{ $producto->stock }}</p>
                    @else
                        <p class="text-oro-antiguo font-bold mb-4">Agotado</p>
                    @endif

                    {{-- botón para eliminar el producto --}}
                    <div class="flex justify-end">
                        <form action="{{ route('productos.destroy', $producto->id) }}" method="POST" id="delete-form">
                            @csrf   <!-- Token CSRF obligatorio para formularios POST en Laravel -->

                            @method('DELETE')   <!-- Método HTTP DELETE para eliminar el recurso -->

                            <!-- Botón que dispara el formulario -->
                            <button id="delete-button" type="submit"
                            class="px-4 py-2 bg-marron-chocolate text-beige-tostado font-semibold rounded-md shadow-sm hover:bg-oro-antiguo">
                                Eliminar Producto
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>

    {{-- Script de confirmación antes de eliminar --}}
    <script>
        // Selecciona el botón de eliminar
        document.getElementById('delete-button').addEventListener('click', function(event){
            event.preventDefault(); // Evita que el formulario se envíe automáticamente
            // Muestra alerta de confirmación
            const confirmacion = confirm('¿Estás seguro que deseas eliminar este producto?');
            if(confirmacion){
                // Si el usuario confirma, envía el formulario
                document.getElementById('delete-form').submit();
            }
        })
    </script>

</x-app-layout>
