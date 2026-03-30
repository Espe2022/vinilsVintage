<?php

namespace App\Http\Controllers;

// ================================
// IMPORTACIONES
// ================================

// Manejo de peticiones HTTP
use Illuminate\Http\Request;

// Sistema de autenticación (usuario logueado)
use Illuminate\Support\Facades\Auth;

// Modelos de la aplicación
use App\Models\Carrito;
use App\Models\Producto;

/*
|--------------------------------------------------------------------------
| Controlador del carrito de compras
|--------------------------------------------------------------------------
|
| Este controlador gestiona todas las operaciones relacionadas con el
| carrito de compra (CRUD):
| - Añadir productos
| - Ver carrito
| - Actualizar cantidades
| - Eliminar productos
| Además, asegurando validaciones como el control de stock.
|
*/

class CarritoController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Añadir producto al carrito
    |--------------------------------------------------------------------------
    */
    public function store($id)
    {
        //Obtiene el ID del usuario autenticado actualmente en la sesión
        $user_id = Auth::id();

        /*Busca en la tabla productos el registro con ese id.
        Si lo encuentra, te devuelve el modelo en la variable $producto.
        Si no existe ese id, lanza un error 404*/
        $producto = Producto::findOrFail($id);

        /*Si el stock es 0 o negativo, no sigue con la lógica de añadir al carrito.
        En su lugar, redirige a la página anterior (back()) y guarda en sesión un mensaje flash 
        de error: "Este producto está agotado"*/
        if ($producto->stock <= 0) {
            return redirect()->back()->with('error', 'Este producto está agotado.');
        }

        //Comprueba si el producto ya está en el carrito
        $item = Carrito::where('user_id', $user_id)
                        ->where('producto_id', $id)
                        ->first();

        /*Si el usuario ya tiene ese producto en el carrito:
        Comprueba si la cantidad actual es mayor o igual que el stock.
        Si ya ha llegado al máximo → devuelve error y no incrementa.
        Si aún no ha llegado → hace increment('cantidad').
        Si todavía no lo tiene:
        Crea la línea en el carrito con cantidad 1.*/
        if ($item) {
            if ($item->cantidad >= $producto->stock) {
                return redirect()->back()->with('error', 'No puedes añadir más unidades. Stock máximo alcanzado.');
            }
            //Ya existe: aumentar cantidad
            $item->increment('cantidad');
        } else {
            //No existe: agregar nuevo
            Carrito::create([
                'user_id' => $user_id,
                'producto_id' => $id,
                'cantidad' => 1,
            ]);
        }

        //Redirige al catálogo y mensaje de éxito con (session('success'))
        return redirect()->route('catalogo')->with('success', 'Vinilo añadido al carrito 🛒');
    }

    /*
    |--------------------------------------------------------------------------
    | Mostrar carrito
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        /*Obtener todos los productos del usuario actual
        with('producto') carga la relación para evitar consultas extra (Eager Loading)*/
        $items = Carrito::with('producto')
            ->where('user_id', Auth::id())
            ->get();

        //Calcular el total del carrito
        $total = $items->sum(function ($item) {
            //Multiplica el precio del producto por la cantidad de ese item
            return $item->producto->precio * $item->cantidad;
        });

        
        // Enviar datos a la vista carrito.index
        return view('carrito.index', compact('items', 'total'));
    }

     /*
    |--------------------------------------------------------------------------
    | Actualizar cantidad de un producto
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, $id)
    {
        //Busca un único registro de carrito del usuario logueado y, si no existe, lanza un 404
        $item = Carrito::with('producto')
            ->where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        // Obtener el producto relacionado
        $producto = $item->producto;

        // Obtener la nueva cantidad desde el formulario
        $nuevaCantidad = (int) $request->input('cantidad');

        // Si la cantidad es 0 → eliminar el producto del carrito
        if ($nuevaCantidad === 0) {
            return $this->destroy($id);
        }

        //Validar que la nueva cantidad no supere el stock disponible sino da error
        if ($nuevaCantidad > $producto->stock) {
            return redirect()->back()->with('error', 'No hay suficiente stock disponible.');
        }

        //Actualizar la cantidad en el carrito
        $item->cantidad = $nuevaCantidad;
        $item->save();

        //Redirige a la página anterior y guarda un mensaje flash en la sesión
        return redirect()->back()->with('success', 'Cantidad actualizada correctamente.');
    }

    /*
    |--------------------------------------------------------------------------
    | Eliminar producto del carrito
    |--------------------------------------------------------------------------
    */
    public function destroy($id)
    {
        /*Busca un único registro del carrito que pertenezca al usuario logueado y tenga ese id, 
        y si no existe lanza un 404*/
        $item = Carrito::where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        //Elimina permanentemente el registro del modelo Carrito de la base de datos
        $item->delete();

        //Redirige y mensaje de éxito con (session('success'))
        return redirect()->back()->with('success', 'Producto eliminado del carrito 🗑️');
    }
}

