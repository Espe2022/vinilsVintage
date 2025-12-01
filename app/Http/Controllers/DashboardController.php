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
