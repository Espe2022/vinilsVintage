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

            {{-- Categoría del producto --}}
            <div class="mb-4">
                <label for="categoria" class="block text-sm font-medium text-marron-chocolate">Categoría:</label>
                <!-- Array de categorías -->
                @php
                    $categorias = ['Rock', 'Pop', 'Jazz', 'Blues', 'Romántica latinoamericana', 'Reguetón', 'Soul', 'Rancheras', 'Latino'];
                @endphp

                <select name="categoria" id="categoria"
                        class="mt-1 block w-full rounded-md bg-beige-crema border-marron-chocolate focus:border-oro-antiguo focus:ring-oro-antiguo shadow-sm sm:text-sm"
                        required>
                    <option value="">Selecciona una categoría</option>
                    @foreach ($categorias as $categoria)
                        <option value="{{ $categoria }}"
                            {{ old('categoria') == $categoria ? 'selected' : '' }}>
                            {{ $categoria }}
                        </option>
                    @endforeach
                </select>

                {{-- Mensaje de error --}}
                {{-- Validar formulario por parte del usuario y renderizar un posible error --}}
                @error('categoria')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>

            {{-- Nombre del producto --}}
            <div class="mb-4">
                <label for="nombre" class="block text-sm font-medium text-marron-chocolate">Nombre del producto</label>
                <input type="text" name="nombre" id="nombre"
                        value="{{ old('nombre') }}"
                        placeholder="Escribe el nombre del vinilo"
                        class="mt-1 block w-full rounded-md bg-beige-crema border-marron-chocolate focus:border-oro-antiguo focus:ring-oro-antiguo shadow-sm sm:text-sm" required>
                
                {{-- Mensaje de error --}}
                {{-- Validar formulario por parte del usuario y renderizar un posible error --}}
                @error('nombre')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>

            {{-- Descripción --}}
            <div class="mb-4">
                <label for="descripcion" class="block text-sm font-medium text-marron-chocolate">Descripción</label>
                <textarea name="descripcion" id="descripcion" rows="3"
                        class="mt-1 block w-full rounded-md bg-beige-crema border-marron-chocolate focus:border-oro-antiguo focus:ring-oro-antiguo shadow-sm sm:text-sm" 
                        placeholder="Descripción del vinilo"
                        required>{{ old('descripcion') }}</textarea>
                
                {{-- Mensaje de error --}}
                {{-- Validar formulario por parte del usuario y renderizar un posible error --}}
                @error('descripcion')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>

            {{-- Precio --}}
            <div class="mb-4">
                <label for="precio" class="block text-sm font-medium text-marron-chocolate">Precio</label>
                <input type="number" name="precio" id="precio" step="0.01" min="0"
                       value="{{ old('precio') }}"
                        class="mt-1 block w-full rounded-md bg-beige-crema border-marron-chocolate focus:border-oro-antiguo focus:ring-oro-antiguo shadow-sm sm:text-sm" 
                        placeholder="Ejemplo: 29.99" required>

                {{-- Mensaje de error --}}
                {{-- Validar formulario por parte del usuario y renderizar un posible error --}}
                @error('precio')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>

            {{-- Stock --}}
            <div class="mb-4">
                <label for="stock" class="block text-sm font-medium text-marron-chocolate">Stock</label>
                <input type="number" name="stock" id="stock" step="1" min="1" 
                       value="{{ old('stock', $producto->stock ?? '') }}"
                       class="mt-1 block w-full rounded-md bg-beige-crema border-marron-chocolate shadow-sm
                       focus:border-oro-antiguo focus:ring-oro-antiguo sm:text-sm"
                       placeholder="Ejemplo: 20" required
                       oninput="this.value = this.value.replace(/[^0-9]/g, '');">   <!-- Patrón para admitir en Cantidad sólo números del 0 al 9 -->
                       
                {{-- Mensaje de error --}}
                {{-- Validar formulario por parte del usuario y renderizar un posible error --}}
                @error('stock')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>

            {{-- Elegir la url de la imagen del disco --}}
            <div class="mb-4">
                <label for="imagen">Seleccionar URL de la Imagen</label>
                <input type="url" name="imagen" id="imagen"
                       value="{{ old('imagen') }}"
                       class="mt-1 block w-full rounded-md bg-beige-crema border-marron-chocolate focus:border-oro-antiguo focus:ring-oro-antiguo shadow-sm sm:text-sm" 
                       placeholder="Ejemplo: https://upload.wikimedia.org/wikipedia/en/1/15/Whitney_Houston_-_Whitney.png" required>

                {{-- Mensaje de error --}}
                {{-- Validar formulario por parte del usuario y renderizar un posible error --}}
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

    <!-- Incluir Pie de página -->
    @include('pie.footer')
</x-app-layout>