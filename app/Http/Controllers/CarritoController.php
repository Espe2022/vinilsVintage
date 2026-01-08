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

        //Comprobar si el producto ya está en el carrito
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

        //Redirección y mensaje de éxito con (session('success'))
        return redirect()->route('catalogo')->with('success', 'Vinilo añadido al carrito 🛒');
    }

    public function index()
    {
        $items = Carrito::with('producto')
            ->where('user_id', Auth::id())
            ->get();

        //Calcular el total del carrito
        $total = $items->sum(function ($item) {
            //Multiplica el precio del producto por la cantidad de ese item
            return $item->producto->precio * $item->cantidad;
        });

        //Pasar tanto los items como el total a la vista
        return view('carrito.index', compact('items', 'total'));
    }

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

        //Validar que la nueva cantidad no supere el stock disponible
        if ($nuevaCantidad > $producto->stock) {
            return redirect()->back()->with('error', 'No hay suficiente stock disponible.');
        }

        //Guardar cambios solo en el carrito
        $item->cantidad = $nuevaCantidad;
        $item->save();

        return redirect()->back()->with('success', 'Cantidad actualizada correctamente.');
    }


        // Buscar el item del carrito
        // $item = Carrito::findOrFail($id);
        // $producto = $item->producto;

        // Nueva cantidad enviada desde el select/input
        // $nuevaCantidad = (int)$request->input('cantidad');

        // Eliminar el item si se selecciona 0
        // if ($nuevaCantidad === 0) 
        // {
        //     return $this->destroy($id);
        // }

        // if ($nuevaCantidad > $item->cantidad) 
        // {
        //     El usuario quiere más unidades
        //     $diferencia = $nuevaCantidad - $item->cantidad;
        //     if ($producto->stock < $diferencia) {
        //         return redirect()->back()->with('error', 'No hay suficiente stock disponible.');
        //     }
        //     $producto->stock -= $diferencia;
        // } else {
        //     El usuario reduce unidades
        //     $diferencia = $item->cantidad - $nuevaCantidad;
        //     $producto->stock += $diferencia;
        // }

        // Guardar cambios
        // $producto->save();
        // $item->cantidad = $nuevaCantidad;
        // $item->save();

        // return redirect()->back()->with('success', 'Cantidad actualizada correctamente.');
    

    public function destroy($id)
    {
        $item = Carrito::findOrFail($id);
        $item->delete();

        //Redirección y mensaje de éxito con (session('success'))
        return redirect()->back()->with('success', 'Producto eliminado del carrito 🗑️');
    }

}
