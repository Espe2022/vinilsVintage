<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-marron-chocolate bg-oro-antiguo leading-tight">
            Crear Producto
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto bg-beige-crema p-6 pb-24 rounded-lg shadow-md mt-10">
        <h2 class="text-2xl font-bold text-beige-tostado bg-marron-chocolate hover:bg-oro-antiguo mb-6">Añadir Producto</h2>

        <form action="/productos" method="POST">
            @csrf   <!--Formulario protegido-->

            {{-- Nombre del producto --}}
            <div class="mb-4">
                <label for="nombre" class="block text-sm font-medium text-marron-chocolate">Nombre del producto</label>
                <select name="nombre" id="nombre"
                        class="mt-1 block w-full rounded-md bg-beige-crema border-marron-chocolate focus:border-oro-antiguo focus:ring-oro-antiguo shadow-sm sm:text-sm" required>
                    <option value="">Selecciona un producto</option>
                        @foreach ($productos as $producto)
                            <option value="{{ $producto->nombre }}" {{ old('producto_nombre') == $producto->nombre ? 'selected' : '' }}>
                                {{ $producto->nombre }}
                            </option>
                        @endforeach
                </select>
                
                @error('nombre')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror

            </div>

            {{-- Descripción --}}
            <div class="mb-4">
                <label for="descripcion" class="block text-sm font-medium text-marron-chocolate">Descripción</label>
                <textarea name="descripcion" id="descripcion" rows="4" 
                        class="mt-1 block w-full rounded-md bg-beige-crema border-marron-chocolate focus:border-oro-antiguo focus:ring-oro-antiguo shadow-sm sm:text-sm"
                        placeholder="Ejemplo: Descripción detallada del producto..." required>{{old('descripcion')}}</textarea>
                        {{-- Validar formulario por parte del usuario y renderizar un posible error --}}
                        @error('descripcion')
                                <span class="text-sm text-red-600">{{$message}}</span>
                        @enderror
            </div>

            {{-- Precio --}}
            <div class="mb-4">
                <label for="precio" class="block text-sm font-medium text-marron-chocolate">Precio</label>
                <input type="number" step="0.01" name="precio" id="precio" 
                       class="mt-1 block w-full rounded-md bg-beige-crema border-marron-chocolate focus:border-oro-antiguo focus:ring-oro-antiguo shadow-sm
                       sm:text-sm"
                       placeholder="Ejemplo: 210.99" value="{{old('precio')}}" required>
                       {{-- Validar formulario por parte del usuario y renderizar un posible error --}}
                       @error('precio')
                            <span class="text-sm text-red-600">{{$message}}</span>
                       @enderror
            </div>

            {{-- Cantidad --}}
            <div class="mb-4">
                <label for="cantidad" class="block text-sm font-medium text-marron-chocolate">Cantidad</label>
                <input type="number" name="cantidad" id="cantidad" step="1" min="1" 
                       class="mt-1 block w-full rounded-md bg-beige-crema border-marron-chocolate shadow-sm
                       focus:border-oro-antiguo focus:ring-oro-antiguo sm:text-sm"
                       placeholder="Ejemplo: 20" value="{{old('cantidad')}}" required
                       oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                       {{-- Validar formulario por parte del usuario y renderizar un posible error --}}
                       @error('cantidad')
                            <span class="text-sm text-red-600">{{$message}}</span>
                       @enderror
            </div>

            {{-- Elegir la imagen de la BD --}}
            <div class="mb-4">
                <label for="imagen">Seleccionar URL de la Imagen:</label>
                <select name="imagen" id="imagen" 
                    class="mt-1 block w-full rounded-md bg-beige-crema border-marron-chocolate focus:border-oro-antiguo focus:ring-oro-antiguo shadow-sm sm:text-sm" required>
                    <option value="">-- Elige una URL --</option>
                        @foreach($urlsImagen as $url)
                            {{-- El valor y el texto visible son la URL --}}
                            <option value="{{ $url }}">{{ $url }}</option>
                        @endforeach
                </select>

                @error('imagen')
                    <div class="alert alert-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            {{-- Botón de enviar --}}
            <div class="flex justify-end">
                <button type="submit" 
                    class="px-4 py-2 bg-marron-chocolate text-beige-tostado font-semibold rounded-md shadow-sm hover:bg-oro-antiguo focus:outline-none">
                    Guardar producto
                </button>
            </div>
        </form>
    </div>
</x-app-layout>