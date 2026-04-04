<x-app-layout>
    <div class="bg-crema-suave">
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-marron-chocolate bg-oro-antiguo leading-tight">
                Dashboard
            </h2>
        </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                <div class="text-center mb-4">
                    <x-auth-session-status
                        class="inline-block text-lg font-semibold text-marron-chocolate bg-oro-antiguo/40 px-3 py-1 rounded"
                        :status="session('status')"
                    />
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-beige-crema border-b border-gray-200">
                        <h1 class="bg-marron-chocolate text-beige-tostado text-5xl text-center font-bold mb-8">
                            <!-- mb-8 indica el margen entre el h1 y la tabla -->
                        Histórico de los productos
                        </h1>    
                    
                        @if(auth()->user()->isAdmin())
                            <h2 class="bg-marron-chocolate text-beige-tostado text-3xl text-center font-bold mb-4">
                                Stock actual
                            </h2>

                            <table class="min-w-full divide-y divide-gray-200 mb-10">
                                <thead class="bg-oro-antiguo text-s font-medium">
                                    <tr>
                                        <th class="px-4 py-2 text-left text-marron-chocolate uppercase tracking-wider">
                                            Producto (fecha)
                                        </th>
                                        <th class="px-4 py-2 text-left text-marron-chocolate uppercase tracking-wider">
                                            Stock
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-amber-200 divide-y divide-gray-200">
                                    @foreach($productosPropios as $producto)
                                        <tr>
                                            <td class="px-4 py-2 text-sm text-marron-chocolate">
                                                {{ $producto['nombre'] }}
                                            </td>
                                            <td class="px-4 py-2 text-sm text-marron-chocolate">
                                                {{ $producto['cantidad'] }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif

                        <h2 class="bg-marron-chocolate text-beige-tostado text-3xl text-center font-bold mb-4">
                            @if(auth()->user()->isAdmin())
                                Nuevas compras
                            @else
                                Mis compras recientes
                            @endif
                        </h2>

                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-oro-antiguo text-s font-medium">
                                <tr>
                                    <th class="px-4 py-2 text-left text-marron-chocolate uppercase tracking-wider">
                                        Producto (fecha)
                                    </th>
                                    <th class="px-4 py-2 text-left text-marron-chocolate uppercase tracking-wider">
                                        Cantidad comprada
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-amber-100 divide-y divide-gray-200">
                                @forelse($productosComprados as $producto)
                                    <tr>
                                        <td class="px-4 py-2 text-sm text-marron-chocolate">
                                            {{ $producto['nombre'] }}
                                        </td>
                                        <td class="px-4 py-2 text-sm text-marron-chocolate">
                                            {{ $producto['cantidad'] }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="px-4 py-4 text-center text-marron-chocolate">
                                            No hay compras registradas.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
 
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
