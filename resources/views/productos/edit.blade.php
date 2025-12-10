<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-marron-chocolate bg-oro-antiguo leading-tight">
            Editar Producto
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto bg-beige-crema p-6 pb-24 rounded-lg shadow-md mt-10">
        <h3 class="text-2xl font-bold text-beige-tostado bg-marron-chocolate mb-6">Actualizar Producto</h3>

        <form action="{{ route('productos.update', $producto->id) }}" method="POST">
            @csrf   <!--Formulario protegido-->
            @method('PUT')

            {{-- Nombre del producto --}}
            <div class="mb-4 bg-beige-crema">
                <label for="nombre" class="block text-sm font-medium text-marron-chocolate">Nombre del producto</label>
                <input type="text" name="nombre" id="nombre"
                    value="{{ old('nombre') ?? $producto->nombre}}" 
                    class="mt-1 block w-full rounded-md shadow-sm border-marron-chocolate focus:border-oro-antiguo focus:ring-oro-antiguo sm:text-sm"
                    placeholder="Ejemplo: Boleros" required>
                    {{-- Validar formulario por parte del usuario y renderizar un posible error.
                    Value sirve, por si hay un error, que no desaparezcan los datos introducidos --}}
                    @error('nombre')
                        <span class="text-sm text-red-600">{{$message}}</span>
                    @enderror
            </div>

            {{-- Descripción --}}
            <div class="mb-4 bg-beige-crema">
                <label for="descripcion" class="block text-sm font-medium text-marron-chocolate">Descripción</label>
                <textarea name="descripcion" id="descripcion" rows="4" 
                    class="mt-1 block w-full rounded-md shadow-sm border-marron-chocolate  focus:border-oro-antiguo focus:ring-oro-antiguo sm:text-sm"
                    placeholder="Ejemplo: Descripción detallada del producto..." required>{{ old('descripcion') ?? $producto->descripcion }}</textarea>
                    {{-- Validar formulario por parte del usuario y renderizar un posible error --}}
                    @error('descripcion')
                            <span class="text-sm text-red-600">{{$message}}</span>
                    @enderror
            </div>

            {{-- Precio --}}
            <div class="mb-4 bg-beige-crema">
                <label for="precio" class="block text-sm font-medium text-marron-chocolate">Precio</label>
                <input type="number" step="0.01" name="precio" id="precio" 
                    value="{{ old('precio') ?? $producto->precio}}" 
                    class="mt-1 block w-full rounded-md shadow-sm border-marron-chocolate  focus:border-oro-antiguo focus:ring-oro-antiguo sm:text-sm"
                    placeholder="Ejemplo: 210.99" required>
                    {{-- Validar formulario por parte del usuario y renderizar un posible error --}}
                    @error('precio')
                        <span class="text-sm text-red-600">{{$message}}</span>
                    @enderror
            </div>

            {{-- Cantidad --}}
            <div class="mb-4 bg-beige-crema">
                <label for="cantidad" class="block text-sm font-medium text-marron-chocolate">Cantidad</label>
                <input type="number" name="cantidad" id="cantidad" step="1" min="1"
                    value="{{ old('cantidad') ?? $producto->cantidad}}" 
                    class="mt-1 block w-full rounded-md shadow-sm border-marron-chocolate  focus:border-oro-antiguo focus:ring-oro-antiguo sm:text-sm"
                    placeholder="Ejemplo: 20" required
                    oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                    {{-- Validar formulario por parte del usuario y renderizar un posible error --}}
                    @error('cantidad')
                        <span class="text-sm text-red-600">{{$message}}</span>
                    @enderror
            </div>

            {{-- Stock --}}
            <div class="mb-4">
                <label for="stock" class="block text-sm font-medium text-marron-chocolate">Stock</label>
                <input type="number" name="stock" id="stock" step="1" min="1" 
                       value="{{old('stock')}}"
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

            {{-- Botón de enviar --}}
            <div class="flex justify-end">
                <button type="submit" 
                    class="px-4 py-2 text-beige-tostado bg-marron-chocolate hover:bg-oro-antiguo font-semibold rounded-md shadow-sm focus:outline-none">
                    Actualizar Producto
                </button>
            </div>
        </form>
    </div>

    <!-- Incluir Pie de página -->
    @include('pie.footer')
</x-app-layout>