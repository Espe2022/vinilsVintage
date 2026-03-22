<?php

namespace App\Http\Controllers;

//Importa las clases:
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Carrito;
use App\Models\Producto;

//Controlador completo del carrito de compras. Maneja todas las operaciones CRUD del carrito
class CarritoController extends Controller
{
    //Añadir al carrito
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

    //Ver carrito
    public function index()
    {
        //Carga el carrito completo del usuario actual
        $items = Carrito::with('producto')
            ->where('user_id', Auth::id())
            ->get();

        //Calcular el total del carrito
        $total = $items->sum(function ($item) {
            //Multiplica el precio del producto por la cantidad de ese item
            return $item->producto->precio * $item->cantidad;
        });

        //Pasar tanto los items como el total a la vista carrito.index
        return view('carrito.index', compact('items', 'total'));
    }

    //Cambiar cantidad
    public function update(Request $request, $id)
    {
        //Buscar el item del carrito junto con el producto
        $item = Carrito::with('producto')->findOrFail($id);
        $producto = $item->producto;

        //Nueva cantidad enviada desde el select/input
        $nuevaCantidad = (int) $request->input('cantidad');

        //Eliminar el item si se selecciona 0
        if ($nuevaCantidad === 0) {
            return $this->destroy($id);
        }

        //Validar que la nueva cantidad no supere el stock disponible sino da error
        if ($nuevaCantidad > $producto->stock) {
            return redirect()->back()->with('error', 'No hay suficiente stock disponible.');
        }

        //Guardar cambios solo en el carrito
        $item->cantidad = $nuevaCantidad;
        $item->save();

        //Redirige a la página anterior y guarda un mensaje flash en la sesión
        return redirect()->back()->with('success', 'Cantidad actualizada correctamente.');
    }

    //Eliminar producto
    public function destroy($id)
    {
        //Busca un registro específico por su ID y lanza error 404 si no existe
        $item = Carrito::findOrFail($id);

        //Elimina permanentemente el registro del modelo Carrito de la base de datos
        $item->delete();

        //Redirige y mensaje de éxito con (session('success'))
        return redirect()->back()->with('success', 'Producto eliminado del carrito 🗑️');
    }

}
