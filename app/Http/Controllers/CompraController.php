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
    /*Método que convierte el carrito en una compra real, descontando stock de cada vinilo, registrando
    lo comprado y vaciando el carrito, todo de forma segura con transacciones*/
    public function comprar()
    {
        //Obtiene el usuario logueado
        $user = Auth::user();

        //Obtiene los productos del carrito del usuario (todos los items)
        $carrito = Carrito::where('user_id', $user->id)->get();

        //Si no hay nada, devuelve un mensaje de error
        if ($carrito->isEmpty()) {
            return redirect()->back()->with('error', 'Tu carrito está vacío.');
        }

        //Transacción de base de datos
        try {
            //Se encarga del commit/rollback automáticamente si hay una excepción
            DB::transaction(function () use ($carrito, $user) {

                //El foreach recorre todo el carrito, descuenta stock y crea los ProductoComprado
                foreach ($carrito as $item) {
                    /*Buscar producto y bloquear la fila para evitar que dos usuarios compren a la 
                    vez el mismo disco y dejen el stock en negativo*/
                    $producto = Producto::lockForUpdate()->findOrFail($item->producto_id);

                    //Comprobar stock suficiente; si no, lanza una excepción
                    if ($producto->stock < $item->cantidad) {
                        throw new \Exception(
                            'No hay stock suficiente de: ' . $producto->nombre
                        );
                    }

                    //Descontar stock del producto
                    $producto->decrement('stock', $item->cantidad);

                    //Guardar cada producto como comprado
                    ProductoComprado::create([
                        'user_id' => $user->id,
                        'product_id' => $item->producto_id,
                        'cantidad' => $item->cantidad,
                    ]);
                }

                //Al final, borra todos los items del carrito del usuario (vacia el carrito)
                Carrito::where('user_id', $user->id)->delete();

            });

        } catch (Exception $e) {
            //Si falla algo (por ejemplo, falta de stock), te devuelve a la página anterior con un mensaje de error
            return redirect()->back()->with('error', $e->getMessage());
        }

        //Si todo va bien, te devuelve a la misma página con un mensaje de éxito
        return redirect()->back()->with('success', '¡Compra realizada con éxito!');
    }
}
