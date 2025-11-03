<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar Producto
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto bg-white p-6 pb-24 rounded-lg shadow-md mt-10">
        <h3 class="text-2xl font-bold text-gray-800 mb-6">Actualizar Producto</h3>

        <form action="{{ route('productos.update', $producto->id) }}" method="POST">
            @csrf   <!--Formulario protegido-->
            @method('PUT')

            {{-- Nombre del producto --}}
            <div class="mb-4">
                <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre del producto</label>
                <input type="text" name="nombre" id="nombre"
                    value="{{ old('nombre') ?? $producto->nombre}}" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm
                            focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    placeholder="Ejemplo: Boleros" required>
                    {{-- Validar formulario por parte del usuario y renderizar un posible error.
                    Value sirve, por si hay un error, que no desaparezcan los datos introducidos --}}
                    @error('nombre')
                        <span class="text-sm text-red-600">{{$message}}</span>
                    @enderror
            </div>

            {{-- Descripción --}}
            <div class="mb-4">
                <label for="descripcion" class="block text-sm font-medium text-gray-700">Descripción</label>
                <textarea name="descripcion" id="descripcion" rows="4" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm
                            focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    placeholder="Ejemplo: Descripción detallada del producto..." required>{{ old('descripcion') ?? $producto->descripcion }}</textarea>
                    {{-- Validar formulario por parte del usuario y renderizar un posible error --}}
                    @error('descripcion')
                            <span class="text-sm text-red-600">{{$message}}</span>
                    @enderror
            </div>

            {{-- Precio --}}
            <div class="mb-4">
                <label for="precio" class="block text-sm font-medium text-gray-700">Precio</label>
                <input type="number" step="0.01" name="precio" id="precio" 
                    value="{{ old('precio') ?? $producto->precio}}" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm
                            focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    placeholder="Ejemplo: 210.99" required>
                    {{-- Validar formulario por parte del usuario y renderizar un posible error --}}
                    @error('precio')
                        <span class="text-sm text-red-600">{{$message}}</span>
                    @enderror
            </div>

            {{-- Cantidad --}}
            <div class="mb-4">
                <label for="cantidad" class="block text-sm font-medium text-gray-700">Cantidad</label>
                <input type="number" name="cantidad" id="cantidad" step="1" min="1"
                    value="{{ old('cantidad') ?? $producto->cantidad}}" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm
                            focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    placeholder="Ejemplo: 20" required
                    oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                    {{-- Validar formulario por parte del usuario y renderizar un posible error --}}
                    @error('cantidad')
                        <span class="text-sm text-red-600">{{$message}}</span>
                    @enderror
            </div>

            {{-- Botón de enviar --}}
            <div class="flex justify-end">
                <button type="submit" 
                    class="px-4 py-2 bg-indigo-600 text-white font-semibold rounded-md shadow-sm hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    Actualizar Producto
                </button>
            </div>
        </form>
    </div>
</x-app-layout>