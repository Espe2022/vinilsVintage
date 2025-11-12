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
        // //Obtener todos los productos propios por un usuario autenticado para hacer el gráfico
        // $productos = Producto::where('user_id', Auth::id())
        //     ->select('nombre', 'cantidad')
        //     ->get();

        // //Obtener los productos comprados (del carrito) por el usuario autenticado, agrupados por producto
        // $compras = ProductoComprado::where('user_id', Auth::id())
        //     ->select('product_id', DB::raw('SUM(cantidad) as total'))
        //     ->groupBy('product_id')
        //     ->get();

        // //Array para todos los productos
        // $comprasTotales = collect();

        // foreach ($compras as $compra) {
        //     $producto = Producto::find($compra->product_id);
        //         if ($producto) {
        //             $comprasTotales->push([
        //                 'nombre' => $producto->nombre,
        //                 'cantidad' => $compra->total,
        //             ]);
        //         }
        // }

        // //Unir los productos propios y los productos comprados
        // $productosCombinados = $productos->concat($comprasTotales);


        // //Preparar los datos para el gráfico de barras
        // $nombres = $productosCombinados->pluck('nombre');   //array de los productos de la columna nombre
        // $cantidades = $productosCombinados->pluck('cantidad');  //array de las cantidades

        // //Pasar los datos a la vista
        // return view('dashboard', [
        //     'nombres' => $nombres,
        //     'productos' => $productosCombinados,
        //     'cantidades' => $cantidades
        // // ]);

        // $productos = Producto::where('user_id', Auth::id())
        //     ->select('nombre', 'cantidad', 'created_at')
        //     ->get();

        // // Preparar los nombres con fecha
        // $nombres = $productos->map(function($producto) 
        // {
        //     $fecha = $producto->created_at ? $producto->created_at->format('d/m/Y') : now()->format('d/m/Y');
        //     return $producto->nombre . ' (' . $fecha . ')';
        // });

        // //Obtener los productos comprados (del carrito) por el usuario autenticado, agrupados por producto
        // $compras = ProductoComprado::where('user_id', Auth::id())
        //     ->select('product_id', DB::raw('SUM(cantidad) as total'))
        //     ->groupBy('product_id')
        //     ->get();


        // // Cantidades
        // $cantidades = $productos->pluck('cantidad');

        // $comprasTotales = collect();

        // foreach ($compras as $compra) {
        //     $producto = Producto::find($compra->product_id);
        //     if ($producto) {
        //         $fecha = $producto->created_at ? $producto->created_at->format('d/m/Y') : now()->format('d/m/Y');
        //         $comprasTotales->push([
        //             'nombre' => $producto->nombre . ' (' . $fecha . ')',
        //             'cantidad' => $compra->total,
        //         ]);
        //     }
        // }

        // // Unir productos propios y comprados
        // $productosCombinados = $productos->concat($comprasTotales);

        // // Para Chart.js
        // $nombres = $productosCombinados->pluck('nombre');
        // $cantidades = $productosCombinados->pluck('cantidad');

        // //Pasar los datos a la vista
        // return view('dashboard', [
        //     'nombres' => $nombres,
        //     'productos' => $productosCombinados,
        //     'cantidades' => $cantidades
        // ]);

        //Productos propios del usuario
        $productos = Producto::where('user_id', Auth::id())->get();

        //Transformar productos propios en arrays con nombre y cantidad
        $productosPropios = $productos->map(function($producto){
            $fecha = $producto->created_at ? $producto->created_at->format('d/m/Y') : now()->format('d/m/Y');
            return [
                'nombre' => $producto->nombre . ' (' . $fecha . ')',
                'cantidad' => $producto->cantidad
            ];
        });

        //Productos comprados por el usuario
        $compras = ProductoComprado::where('user_id', Auth::id())
            ->select('product_id', DB::raw('SUM(cantidad) as total'))
            ->groupBy('product_id')
            ->get();

        //Transformar productos comprados en arrays
        $productosComprados = $compras->map(function($compra)
        {
            $producto = Producto::find($compra->product_id);
            if ($producto) {
                //Si el producto tiene fecha de creación: usa esa fecha
                //Si no tiene fecha: usa la fecha actual
                $fecha = $producto->created_at ? $producto->created_at->format('d/m/Y') : now()->format('d/m/Y');
                return [
                    'nombre' => $producto->nombre . ' (' . $fecha . ')',
                    'cantidad' => $compra->total
                ];
            }
        })->filter(); // eliminamos null si algún producto no existe

        // Unir productos propios y comprados
        $productosCombinados = $productosPropios->concat($productosComprados);

        // Preparar datos para Chart.js
        $nombres = $productosCombinados->pluck('nombre');
        $cantidades = $productosCombinados->pluck('cantidad');

        // Pasar a la vista
        return view('dashboard', compact('nombres', 'cantidades', 'productosCombinados'));

    }
}
