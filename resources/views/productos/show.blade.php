<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-marron-chocolate bg-oro-antiguo leading-tight">
            Detalle del Producto
        </h2>
    </x-slot>

    <div class="py-12 bg-beige-crema">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-beige-crema overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8 text-marron-chocolate">
                    <h4 class="font-semibold text-2xl">Nombre del Producto: {{ $producto->nombre }}</h4>
                    <p class="font-light text-lg">{{ $producto->descripcion }}</p>
                    <p class="text-lg">Precio: {{ $producto->precio }} €.</p>
                    <p class="text-lg">Cantidad: {{ $producto->cantidad }} u.</p>
               
                    <!-- Stock con mensaje -->
                    @if($producto->stock > 0)
                        <p class="text-marron-chocolate font-medium mb-4">Stock disponible: {{ $producto->stock }}</p>
                    @else
                        <p class="text-oro-antiguo font-bold mb-4">Agotado</p>
                    @endif

                    {{-- botón de eliminar --}}
                    <div class="flex justify-end">
                        <form action="{{ route('productos.destroy', $producto->id) }}" method="POST" id="delete-form">
                            @csrf 

                            @method('DELETE')
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

    {{-- Código hecho en JavaScript que se usa para mostrar una ventana de confirmación antes de eliminar un producto --}}
    <script>
        document.getElementById('delete-button').addEventListener('click', function(event){
            event.preventDefault();
            const confirmacion = confirm('¿Estás seguro que deseas eliminar este producto?');
            if(confirmacion){
                document.getElementById('delete-form').submit();
            }
        })
    </script>

    <!-- Incluir Pie de página -->
    @include('pie.footer')

</x-app-layout>
