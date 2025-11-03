<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detalle del Producto
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8">
                    <h4 class="font-semibold text-2xl">Nombre del Producto: {{$producto->nombre}}</h4>
                    <p class="font-light text-lg">{{$producto->descripcion}}</p>
                    <p class="text-lg">Precio: {{$producto->precio}} €.</p>
                    <p class="text-lg">Cantidad: {{$producto->cantidad}} u.</p>
                    {{-- botón de eliminar --}}
                    <div class="flex justify-end">
                        <form action="{{ route('productos.destroy', $producto->id) }}" method="POST" id="delete-form">
                            @csrf 
                            @method('DELETE')
                            <button id="delete-button" type="submit"
                            class="px-4 py-2 bg-indigo-600 text-white font-semibold rounded-md shadow-sm hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                Eliminar Producto
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
    {{-- script para la ventana de confirmación --}}
    <script>
        document.getElementById('delete-button').addEventListener('click', function(event){
            event.preventDefault();
            const confirmacion = confirm('¿Estás seguro que deseas eliminar este producto?');
            if(confirmacion){
                document.getElementById('delete-form').submit();
            }
        })
    </script>

</x-app-layout>
