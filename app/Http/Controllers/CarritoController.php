<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Carrito;
use App\Models\Producto;


class CarritoController extends Controller
{
    public function store($id)
    {
        $user_id = Auth::id();

        // Comprobar si el producto ya está en el carrito
        $item = Carrito::where('user_id', $user_id)
                        ->where('producto_id', $id)
                        ->first();

        if ($item) {
            // Ya existe → aumentar cantidad
            $item->increment('cantidad');
        } else {
            // No existe → agregar nuevo
            Carrito::create([
                'user_id' => $user_id,
                'producto_id' => $id,
                'cantidad' => 1,
            ]);
        }

        return redirect()->route('catalogo')->with('success', 'Vinilo añadido al carrito 🛒');
    }

    public function index()
    {
        $items = Carrito::with('producto')
            ->where('user_id', Auth::id())
            ->get();

        return view('carrito.index', compact('items'));
    }

    public function destroy($id)
    {
        $item = Carrito::findOrFail($id);
        $item->delete();
        return redirect()->back()->with('success', 'Producto eliminado del carrito 🗑️');
    }

}
