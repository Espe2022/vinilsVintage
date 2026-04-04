<x-app-layout>
    <!-- Encabezado de la página -->
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-marron-chocolate bg-oro-antiguo leading-tight">
            Lista de productos
        </h2>
    </x-slot>

    <!-- Contenedor principal de la lista de productos -->
    <div class="py-12 bg-crema-suave">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-crema-suave overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <!-- Botón para crear un nuevo producto -->
                <div class="mb-4">
                    <a href="{{ route('productos.create') }}" class="text-beige-tostado bg-marron-chocolate hover:bg-oro-antiguo px-4 py-2 rounded">
                        Crear producto
                    </a>
                </div>

                <!-- Tabla que muestra todos los productos -->
                <table class="table-auto w-full border-collapse border-2 border-marron-chocolate text-marron-chocolate">
                    <thead>
                        <tr class="bg-beige-crema">
                            <th class="border border-marron-chocolate px-4 py-2">Nombre</th>
                            <th class="border border-marron-chocolate px-4 py-2">Descripción</th>
                            <th class="border border-marron-chocolate px-4 py-2">Precio</th>
                            <th class="border border-marron-chocolate px-4 py-2">Stock</th>
                            <th class="border border-marron-chocolate px-4 py-2">Creado por</th>
                            <th class="border border-marron-chocolate px-4 py-2">Ver</th>
                            <th class="border border-marron-chocolate px-4 py-2">Actualizar</th>
                        </tr>
                    </thead>

                    <tbody>
                                            
                        <!-- Iterar productos; si no hay ninguno, mostrar mensaje -->
                        @forelse ($productos as $producto)
                            <tr class="bg-beige-crema">
                                <!-- Nombre del producto -->    
                                <td class="border border-marron-chocolate px-4 py-2">{{ $producto->nombre }}</td>
                                <!-- Descripción -->
                                <td class="border border-marron-chocolate px-4 py-2">{{ $producto->descripcion }}</td>
                                <!-- Precio -->
                                <td class="border border-marron-chocolate px-4 py-2">{{ $producto->precio }}</td>
                                <!-- Stock con condición: si es 0, mostrar 'Agotado' -->
                                <td class="border border-marron-chocolate px-4 py-2">
                                    @if($producto->stock > 0)
                                        <p class="text-marron-chocolate font-medium mb-4">{{ $producto->stock }}</p>
                                    @else
                                        <p class="text-oro-antiguo font-bold mb-4">Agotado</p>
                                    @endif
                                </td>
                                <!-- Nombre del usuario que creó el producto -->
                                <td class="border border-marron-chocolate px-4 py-2">{{ $producto->user->name ?? 'Sin asignar' }}</td> {{-- Nombre del creador --}}
                                <!-- Botón para ver detalles del producto -->
                                <td class="border border-marron-chocolate px-4 py-2">
                                    <a href="{{ route('productos.show', $producto->id) }}">
                                    <ion-icon name="eye" class="text-marron-chocolate text-3xl"></ion-icon>
                                    </a>
                                </td>
                                <td class="border border-marron-chocolate px-4 py-2">
                                    <a href="{{ route('productos.edit', $producto->id) }}">
                                        <ion-icon name="sync-circle" class="text-marron-chocolate text-3xl"></ion-icon>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <!-- Mensaje si no hay productos -->
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    No hay productos registrados.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>

                {{-- Paginación de productos --}}
                <div class="mt-4 p-5">
                    <!-- Renderiza links de paginación -->
                    {{$productos->links()}}
                </div>
            </div>
        </div>
    </div>

</x-app-layout>