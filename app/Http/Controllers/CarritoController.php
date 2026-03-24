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

        //Comprueba si el producto ya está en el carrito
        $item = Carrito::where('user_id', $user_id)
                        ->where('producto_id', $id)
                        ->first();

        if ($item) {
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
        //Obtener todos los productos del usuario actual
        // with('producto') carga la relación para evitar consultas extra (Eager Loading)
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
        //Buscar el item del carrito junto con el producto (o error 404 si no existe)
        $item = Carrito::with('producto')->findOrFail($id);

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
        //Busca un registro específico (item) por su ID y lanza error 404 si no existe
        $item = Carrito::findOrFail($id);

        //Elimina permanentemente el registro del modelo Carrito de la base de datos
        $item->delete();

        //Redirige y mensaje de éxito con (session('success'))
        return redirect()->back()->with('success', 'Producto eliminado del carrito 🗑️');
    }
}

/*
Este sistema permite que los usuarios añadan vinilos al carrito y gestionen su compra 
antes de finalizar el pedido.
He aplicado buenas prácticas como evitar duplicados en el carrito, validar stock 
y optimizar consultas mediante Eloquent.

Auth::id()     Permite asociar el carrito al usuario autenticado.
Eager Loading (with('producto'))    Evita consultas innecesarias a la base de datos, 
                                    mejorando el rendimiento.
Validación de stock     Evita que el usuario compre más productos de los disponibles.
Mensajes flash (with('success'))    Se usan para mostrar feedback al usuario tras cada acción.
*/
