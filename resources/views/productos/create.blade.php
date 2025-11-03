<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Crear Producto
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto bg-white p-6 pb-24 rounded-lg shadow-md mt-10">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Añadir Producto</h2>

        <form action="/productos" method="POST">
            @csrf   <!--Formulario protegido-->

            {{-- Nombre del producto --}}
            <div class="mb-4">
                <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre del producto</label>
                <input type="text" name="nombre" id="nombre" 
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm
                              focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                       placeholder="Ejemplo: Boleros" value="{{old('nombre')}}" required>
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
                        placeholder="Ejemplo: Descripción detallada del producto..." required>{{old('descripcion')}}</textarea>
                        {{-- Validar formulario por parte del usuario y renderizar un posible error --}}
                        @error('descripcion')
                                <span class="text-sm text-red-600">{{$message}}</span>
                        @enderror
            </div>

            {{-- Precio --}}
            <div class="mb-4">
                <label for="precio" class="block text-sm font-medium text-gray-700">Precio</label>
                <input type="number" step="0.01" name="precio" id="precio" 
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm
                              focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                       placeholder="Ejemplo: 210.99" value="{{old('precio')}}" required>
                       {{-- Validar formulario por parte del usuario y renderizar un posible error --}}
                       @error('precio')
                            <span class="text-sm text-red-600">{{$message}}</span>
                       @enderror
            </div>

            {{-- Cantidad --}}
            <div class="mb-4">
                <label for="cantidad" class="block text-sm font-medium text-gray-700">Cantidad</label>
                <input type="number" name="cantidad" id="cantidad" step="1" min="1" 
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm
                              focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                       placeholder="Ejemplo: 20" value="{{old('cantidad')}}" required
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
                    Guardar producto
                </button>
            </div>
        </form>
    </div>
</x-app-layout>