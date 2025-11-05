<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductoComprado;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;

class CompraController extends Controller
{
     public function comprar()
    {
        $user = Auth::user();

        //Obtener los productos del carrito del usuario
        $carrito = CartItem::where('user_id', $user->id)->get();

        if ($carrito->isEmpty()) {
            return redirect()->back()->with('error', 'Tu carrito está vacío.');
        }

        // Recorrer y guardar cada producto como comprado
        foreach ($carrito as $item) {
            ProductoComprado::create([
                'user_id' => $user->id,
                'product_id' => $item->product_id,
                'cantidad' => $item->cantidad,
            ]);
        }

        //Vaciar el carrito
        CartItem::where('user_id', $user->id)->delete();

        return redirect()->back()->with('success', '¡Compra realizada con éxito!');
    }
}
