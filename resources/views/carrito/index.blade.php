@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6 bg-crema-suave rounded-xl shadow">
    <h2 class="text-5xl text-center font-extrabold leading-tight tracking-tight text-marron-chocolate">🛍️ Tu Carrito</h2>

    @forelse($items as $item)
        <div class="flex items-center justify-between border-b py-4">
            <div class="flex items-center space-x-4">
                <img src="{{ $item->producto->imagen }}" alt="{{ $item->producto->nombre }}" class="w-20 h-20 rounded">
                <div>
                    <h3 class="font-semibold text-lg">{{ $item->producto->nombre }}</h3>
                    <p class="text-gray-500">{{ $item->producto->descripcion }}</p>
                </div>
            </div>

            <div class="text-right">
                <p class="text-green-600 font-bold">${{ number_format($item->producto->precio, 2) }}</p>
                <p>Cantidad: {{ $item->cantidad }}</p>

                <form action="{{ route('carrito.eliminar', $item->id) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button class="text-red-500 hover:text-red-700 font-semibold mt-2">Eliminar</button>
                </form>
            </div>
        </div>
    @empty
        <p class="text-center text-gray-500 mt-6">Tu carrito está vacío 😢</p>
    @endforelse
</div>
@endsection
