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
        $user = Auth::user();

        //Productos
        $productos = $user->isAdmin()
            ? Producto::all()
            : Producto::where('user_id', $user->id)->get();

        $productosPropios = $productos->map(function($producto){
            $fecha = $producto->created_at
                ? $producto->created_at->format('d/m/Y')
                : now()->format('d/m/Y');

            return [
                'nombre'   => $producto->nombre . ' (' . $fecha . ')',
                'cantidad' => $producto->stock,
            ];
        });

        //Compras
        $compras = $user->isAdmin()
            ? ProductoComprado::orderBy('created_at', 'asc')->get()
            : ProductoComprado::where('user_id', $user->id)
                ->orderBy('created_at', 'asc')
                ->get();

        $productosComprados = $compras->map(function($compra) {
            $producto = Producto::find($compra->product_id);
            if ($producto) {
                $fecha = $compra->created_at
                    ? $compra->created_at->format('d/m/Y')
                    : now()->format('d/m/Y');

                return [
                    'nombre'   => $producto->nombre . ' (' . $fecha . ')',
                    'cantidad' => $compra->cantidad,
                ];
            }
        })->filter();

        $productosCombinados = $productosPropios->concat($productosComprados);
        $nombres    = $productosCombinados->pluck('nombre');
        $cantidades = $productosCombinados->pluck('cantidad');

        return view('dashboard', compact('nombres', 'cantidades', 'productosCombinados'));
    }

}
