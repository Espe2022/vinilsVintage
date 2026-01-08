<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductoComprado;
use App\Models\Carrito;
use App\Models\Producto;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CompraController extends Controller
{
    public function comprar()
    {
        $user = Auth::user();

        //Obtener los productos del carrito del usuario
        $carrito = Carrito::where('user_id', $user->id)->get();

        if ($carrito->isEmpty()) {
            return redirect()->back()->with('error', 'Tu carrito está vacío.');
        }

        try {
            //Se encarga del commit/rollback automáticamente si hay una excepción
            DB::transaction(function () use ($carrito, $user) {

                //El foreach recorre todo el carrito, descuenta stock y crea los ProductoComprado
                foreach ($carrito as $item) {
                    //Buscar producto y bloquear la fila para evitar que dos usuarios compren a la vez el mismo disco y dejen el stock en negativo
                    $producto = Producto::lockForUpdate()->findOrFail($item->producto_id);

                    //Comprobar stock suficiente
                    if ($producto->stock < $item->cantidad) {
                        throw new \Exception(
                            'No hay stock suficiente de: ' . $producto->nombre
                        );
                    }

                    //Descontar stock
                    $producto->decrement('stock', $item->cantidad);

                    //Guardar cada producto como comprado
                    ProductoComprado::create([
                        'user_id' => $user->id,
                        'product_id' => $item->producto_id,
                        'cantidad' => $item->cantidad,
                    ]);
                }

                //Vaciar el carrito
                Carrito::where('user_id', $user->id)->delete();

            });

        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->back()->with('success', '¡Compra realizada con éxito!');
    }
}
