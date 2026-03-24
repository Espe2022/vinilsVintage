<?php

namespace App\Http\Controllers;

// ================================
// IMPORTACIONES
// ================================
use Illuminate\Http\Request;
use App\Models\ProductoComprado;
use App\Models\Carrito;
use App\Models\Producto;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| Controlador de compras
|--------------------------------------------------------------------------
|
| Este controlador se encarga de convertir el carrito en una compra real.
| Realiza las siguientes acciones:
| - Verifica el carrito
| - Comprueba el stock
| - Descuenta productos
| - Guarda la compra
| - Vacía el carrito
|
| Todo se ejecuta dentro de una transacción para garantizar consistencia.
|
*/

class CompraController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Finalizar compra
    |--------------------------------------------------------------------------
    |
    | Este método se ejecuta cuando el usuario pulsa "Finalizar compra".
    | Método que convierte el carrito en una compra real, descontando stock de cada vinilo, registrando
    | lo comprado y vaciando el carrito, todo de forma segura con transacciones.
    |
    */
    public function comprar()
    {
        //Obtiene el usuario logueado
        $user = Auth::user();

        //Obtiene los productos del carrito del usuario (todos los items)
        $carrito = Carrito::where('user_id', $user->id)->get();

        //Validar que el carrito no esté vacío: Si no hay nada, devuelve un mensaje de error
        if ($carrito->isEmpty()) {
            return redirect()->back()->with('error', 'Tu carrito está vacío.');
        }

        // ================================
        // TRANSACCIÓN DE BASE DE DATOS
        // ================================
        try {

            /*
            | DB::transaction asegura que:
            | - Si todo va bien → commit (se guarda)
            | - Si falla algo → rollback (se deshace todo)
            */
            DB::transaction(function () use ($carrito, $user) {

                //El foreach recorre todo el carrito
                foreach ($carrito as $item) {

                    /*
                    | lockForUpdate bloquea la fila del producto en la BD
                    | para evitar problemas de concurrencia:
                    | Ej: dos usuarios comprando el mismo vinilo a la vez
                    */
                    $producto = Producto::lockForUpdate()->findOrFail($item->producto_id);

                    //Comprobar stock suficiente
                    if ($producto->stock < $item->cantidad) {
                        //Si no lanza una excepción → provoca rollback automático
                        throw new \Exception(
                            'No hay stock suficiente de: ' . $producto->nombre
                        );
                    }

                    //Descontar stock del producto
                    $producto->decrement('stock', $item->cantidad);

                    /*
                    | Registrar el producto como comprado
                    | (historial de compras del usuario)
                    */
                    ProductoComprado::create([
                        'user_id' => $user->id,
                        'product_id' => $item->producto_id,
                        'cantidad' => $item->cantidad,
                    ]);
                }

                // Vaciar el carrito del usuario tras la compra
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

/*
Este controlador gestiona el proceso de compra completo. Utiliza una transacción de 
base de datos para garantizar que todas las operaciones se ejecuten correctamente o se 
deshagan en caso de error, evitando inconsistencias.

Este sistema permite simular una compra real de vinilos, controlando el stock y 
guardando el historial de compras del usuario.

Transacciones (DB::transaction)     Aseguran la integridad de los datos. Si falla algo, 
                                    se revierte toda la operación.

lockForUpdate()     Bloquea el registro del producto para evitar problemas de concurrencia, 
                    como vender más stock del disponible.

Validación de stock     Se comprueba antes de descontar para evitar errores en la compra.

Vaciado del carrito      Una vez completada la compra, se eliminan los productos del carrito.

Como mejora futura, se podría añadir pago online (Stripe, PayPal) y generación de pedidos.
*/