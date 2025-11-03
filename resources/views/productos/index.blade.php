<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Lista de productos
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                {{-- Mensaje de éxito --}}
                @if (session('success'))
                    <div class="mb-4 p-4 rounded-md bg-green-100 border border-green-300 text-green-800">
                        {{ session('success') }}
                    </div>
                @endif
                
                <div class="mb-4">
                    <a href="{{ route('productos.create') }}" class="text-white bg-blue-500 hover:bg-blue-600 px-4 py-2 rounded">
                        Crear producto
                    </a>
                </div>

                <table class="table-auto w-full border-collapse border border-gray-300">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border px-4 py-2">Nombre</th>
                            <th class="border px-4 py-2">Descripción</th>
                            <th class="border px-4 py-2">Precio</th>
                            <th class="border px-4 py-2">Cantidad</th>
                            <th class="border px-4 py-2">Ver</th>
                            <th class="border px-4 py-2">Actualizar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($productos as $producto)
                            <tr>
                                <td class="border px-4 py-2">{{ $producto->nombre }}</td>
                                <td class="border px-4 py-2">{{ $producto->descripcion }}</td>
                                <td class="border px-4 py-2">{{ $producto->precio }}</td>
                                <td class="border px-4 py-2">{{ $producto->cantidad }}</td>
                                <td class="border px-4 py-2"><a href="{{ route('productos.show', $producto->id) }}">
                                    <ion-icon name="eye" class="text-gray-500 text-3xl"></ion-icon>
                                </a></td>
                                <td class="border px-4 py-2"><a href="{{ route('productos.edit', $producto->id) }}">
                                    <ion-icon name="sync-circle" class="text-gray-500 text-3xl"></ion-icon>
                                </a></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    No hay productos registrados.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                {{-- paginación --}}
                <div class="mt-4 p-5">
                    <!--Renderizar la paginación, usamos $productos que contiene todos los productos-->
                    {{$productos->links()}}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
                    