<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\ProductoComprado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function dashboard()
    {
        //Obtener todos los productos propios por un usuario autenticado para hacer el gráfico
        $productos = Producto::where('user_id', Auth::id())
            ->select('nombre', 'cantidad')
            ->get();


        //Obtener los productos comprados (del carrito) por el usuario autenticado, agrupados por producto
        $compras = ProductoComprado::where('user_id', Auth::id())
            ->select('product_id', DB::raw('SUM(cantidad) as total'))
            ->groupBy('product_id')
            ->get();

        //Array para todos los productos
        $comprasTotales = collect();

        foreach ($compras as $compra) {
            $producto = Producto::find($compra->product_id);
                if ($producto) {
                    $comprasTotales->push([
                        'nombre' => $producto->nombre,
                        'cantidad' => $compra->total,
                    ]);
                }
        }

        //Unir los productos propios y los productos comprados
        $productosCombinados = $productos->concat($comprasTotales);


        //Preparar los datos para el gráfico de barras
        $nombres = $productosCombinados->pluck('nombre');   //array de los productos de la columna nombre
        $cantidades = $productosCombinados->pluck('cantidad');  //array de las cantidades

        //Pasar los datos a la vista
        return view('dashboard', [
            'nombres' => $nombres,
            'cantidades' => $cantidades
        ]);

    }
}
