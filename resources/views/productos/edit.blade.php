{{-- Layout principal de la aplicación --}}
<x-app-layout>

   {{-- Slot para el encabezado --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-marron-chocolate bg-oro-antiguo leading-tight">
            Editar Producto
        </h2>
    </x-slot>

    {{-- Contenedor principal --}}
    <div class="max-w-4xl mx-auto bg-beige-crema p-6 pb-24 rounded-lg shadow-md mt-10">
            
        {{-- Título --}}
        <h3 class="text-2xl font-bold text-beige-tostado bg-marron-chocolate mb-6">Actualizar Producto</h3>

        {{-- 
            Formulario para actualizar un producto existente
            Se envía a la ruta "productos.update" con el ID del producto
        --}}
        <form action="{{ route('productos.update', $producto->id) }}" method="POST">

            {{-- Token CSRF para seguridad --}}
            @csrf   

            {{-- 
                Método PUT simulado (HTML solo soporta GET y POST)
                Se usa para cumplir con REST (UPDATE)
            --}}
            @method('PUT')

            {{-- ================= CATEGORÍA ================= --}}
            <div class="mb-4">
                <label for="categoria" class="block text-sm font-medium text-marron-chocolate">Categoría:</label>
                
                {{-- Array de categorías (normalmente vendría del backend) --}}
                @php
                    $categorias = ['Rock', 'Pop', 'Jazz', 'Blues', 'Romántica latinoamericana', 'Reguetón', 'Soul', 'Rancheras', 'Latino', 'Flamenco', 'Música Clásica'];
                @endphp
                
                {{-- Select dinámico --}}
                <select name="categoria" id="categoria"
                        class="mt-1 block w-full rounded-md bg-beige-crema border-marron-chocolate focus:border-oro-antiguo focus:ring-oro-antiguo shadow-sm sm:text-sm"
                        required>
                    <option value="">Selecciona una categoría</option>

                    {{-- Generar opciones --}}
                    @foreach ($categorias as $categoria)
                        {{-- 
                            Mantiene valor tras error o selecciona el valor actual del producto
                        --}}
                        <option value="{{ $categoria }}" {{ old('categoria', $producto->categoria) == $categoria ? 'selected' : '' }}>
                            {{ $categoria }}
                        </option>
                    @endforeach
                </select>

                {{-- Mostrar error --}}
                @error('categoria')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>
            
            {{-- ================= NOMBRE ================= --}}
            <div class="mb-4 bg-beige-crema">
                <label for="nombre" class="block text-sm font-medium text-marron-chocolate">Nombre del producto</label>
                
                {{-- 
                    Campo texto:
                    - old(): mantiene valor si hay error
                    - $producto->nombre: valor actual de la BD
                --}}
                <input type="text" name="nombre" id="nombre"
                    value="{{ old('nombre') ?? $producto->nombre}}" 
                    class="mt-1 block w-full rounded-md shadow-sm bg-beige-crema border-marron-chocolate focus:border-oro-antiguo focus:ring-oro-antiguo sm:text-sm"
                    placeholder="Ejemplo: Boleros" required>

                    {{-- 
                        Validar formulario por parte del usuario y renderizar un posible error.
                        Value sirve, por si hay un error, que no desaparezcan los datos introducidos 
                    --}}
                    @error('nombre')
                        <span class="text-sm text-red-600">{{$message}}</span>
                    @enderror
            </div>

            {{-- ================= DESCRIPCIÓN ================= --}}
            <div class="mb-4 bg-beige-crema">
                <label for="descripcion" class="block text-sm font-medium text-marron-chocolate">Descripción</label>
                
                {{-- Textarea con valor persistente --}}
                <textarea name="descripcion" id="descripcion" rows="4" 
                    class="mt-1 block w-full rounded-md shadow-sm bg-beige-crema border-marron-chocolate  focus:border-oro-antiguo focus:ring-oro-antiguo sm:text-sm"
                    placeholder="Ejemplo: Descripción detallada del producto..." required>{{ old('descripcion') ?? $producto->descripcion }}</textarea>
                    
                    {{-- 
                        Validar formulario por parte del usuario y renderizar un posible error 
                    --}}
                    @error('descripcion')
                            <span class="text-sm text-red-600">{{$message}}</span>
                    @enderror
            </div>

            {{-- ================= PRECIO ================= --}}
            <div class="mb-4 bg-beige-crema">
                <label for="precio" class="block text-sm font-medium text-marron-chocolate">Precio</label>
                
                {{-- 
                    Campo numérico:
                    - step="0.01" → permite decimales
                --}}
                <input type="number" step="0.01" name="precio" id="precio" 
                    value="{{ old('precio') ?? $producto->precio}}" 
                    class="mt-1 block w-full rounded-md shadow-sm bg-beige-crema border-marron-chocolate  focus:border-oro-antiguo focus:ring-oro-antiguo sm:text-sm"
                    placeholder="Ejemplo: 210.99" required>

                    {{-- 
                        Validar formulario por parte del usuario y renderizar un posible error 
                    --}}
                    @error('precio')
                        <span class="text-sm text-red-600">{{$message}}</span>
                    @enderror
            </div>

            {{-- ================= STOCK ================= --}}
            <div class="mb-4">
                <label for="stock" class="block text-sm font-medium text-marron-chocolate">Stock</label>
                
                {{-- 
                    Campo numérico entero:
                    - min="1" → mínimo 1
                    - oninput → solo permite números
                --}}
                <input type="number" name="stock" id="stock" step="1" min="1" 
                       value="{{ old('stock') ?? $producto->stock }}"
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
            
            {{-- ================= BOTÓN ================= --}}
            <div class="flex justify-end">
                <button type="submit" 
                    class="px-4 py-2 text-beige-tostado bg-marron-chocolate hover:bg-oro-antiguo font-semibold rounded-md shadow-sm focus:outline-none">
                    Actualizar Producto
                </button>
            </div>
        </form>
    </div>

</x-app-layout>