@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6 bg-crema-suave rounded-xl shadow">
    <h2 class="text-5xl text-center font-extrabold leading-tight tracking-tight text-marron-chocolate">🛍️ Tu Carrito</h2>

    @forelse($items as $item)
        <div class="flex items-center justify-between border-b py-4">
            <div class="flex items-center space-x-4">
                <img src="{{ $item->producto->imagen }}" alt="{{ $item->producto->nombre }}" class="w-20 h-20 rounded">
                <div>
                    <h3 class="font-semibold text-lg text-marron-chocolate">{{ $item->producto->nombre }}</h3>
                    <p class="text-oro-antiguo">{{ $item->producto->descripcion }}</p>
                </div>
            </div>

            <div class="text-right">
                <p class="text-beige-tostado font-bold">${{ number_format($item->producto->precio, 2) }}</p>
            
                <!-- Formulario para actualizar cantidad -->
                @php
                    $maxCantidad = $item->producto->stock + $item->cantidad; // máximo que se puede comprar
                @endphp

                <form action="{{ route('carrito.update', $item->id) }}" method="POST" class="inline-block mt-1">
                    @csrf
                    @method('PUT')
                    <select name="cantidad"
                            class="w-20 border border-marron-chocolate rounded px-3 py-2 text-marron-chocolate bg-beige-crema focus:outline-none focus:ring-2 focus:ring-oro-antiguo">
                        @for($i = 1; $i <= $maxCantidad; $i++)
                            <option value="{{ $i }}" {{ $i == $item->cantidad ? 'selected' : '' }}>
                                {{ $i }}
                            </option>
                        @endfor
                    </select>

                    <button type="submit" class="ml-2 bg-marron-chocolate hover:bg-oro-antiguo text-beige-tostado font-semibold py-1 px-3 rounded">
                        Actualizar
                    </button>
                </form>

                <p class="text-marron-chocolate mt-2">
                    Subtotal: {{ number_format($item->producto->precio * $item->cantidad, 2) }} €
                </p>

                <!-- Botón eliminar -->
                <form action="{{ route('carrito.eliminar', $item->id) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button class="text-red-500 hover:text-red-700 font-semibold mt-2">Eliminar</button>
                </form>
            </div>
        </div>

        @empty
        <p class="text-center text-marron-chocolate mt-6">Tu carrito está vacío 😢</p>

    @endforelse

    {{-- Fuera del bucle mostrar el total final --}}
    <div class="text-right">
        <p class="text-marron-chocolate">
            TOTAL: <strong>{{ number_format($total, 2) }} €</strong>
        </p>
    </div>

    <!-- Botón Finalizar compra
    <div class="text-right mt-6">
        <form action="{{ route('comprar') }}" method="POST">
            @csrf
            <button type="submit" class="bg-marron-chocolate hover:bg-oro-antiguo text-white font-semibold py-2 px-4 rounded-full transition w-full max-w-xs">Finalizar compra</button>
        </form>
    </div> -->

    <!-- Botón Finalizar compra -->
    @if($items->count() > 0)
    <div class="text-right mt-6">
        <form action="{{ route('comprar') }}" method="POST">
            @csrf
            <button type="submit" class="bg-marron-chocolate hover:bg-oro-antiguo text-white font-semibold py-2 px-4 rounded-full transition w-full max-w-xs">
                Finalizar compra
            </button>
        </form>
    </div>
    @endif
</div>
   
<!-- Incluir Pie de página -->
@include('pie.footer')

@endsection
