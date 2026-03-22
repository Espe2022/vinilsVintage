<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\ProductoComprado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/*Controlador que construye los datos del panel (dashboard) para mostrar un resumen de productos y 
compras del usuario (o de todos, si es admin)*/
class DashboardController extends Controller
{
    public function dashboard()
    {
        //Obtener usuario autenticado
        $user = Auth::user();

        //Productos del usuario (o todos si es admin)
        $productos = $user->isAdmin()
            ? Producto::all()
            : Producto::where('user_id', $user->id)->get();

        //Mapea a un formato sencillo para el histórico: Recorrer la colección de productos
        $productosPropios = $productos->map(function($producto){
            $fecha = $producto->created_at
                ? $producto->created_at->format('d/m/Y')
                : now()->format('d/m/Y');

            //nombre: “Nombre del vinilo (fecha de creación)”
            //cantidad: el stock actual de ese producto
            return [
                'nombre'   => $producto->nombre . ' (' . $fecha . ')',
                'cantidad' => $producto->stock,
            ];
        });

        //Compras (historial de ProductoComprado):
        //Admin: ve todas las compras de todos los usuarios
        //Usuario: solo sus propias compras
        $compras = $user->isAdmin()
            ? ProductoComprado::orderBy('created_at', 'asc')->get()
            : ProductoComprado::where('user_id', $user->id)
                ->orderBy('created_at', 'asc')
                ->get();

        /*Luego las transforma:
        Busca el Producto asociado a cada ProductoComprado y monta:
        nombre: nombre del vinilo + fecha de compra
        cantidad: cuántas unidades se compraron*/
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
        })->filter();   //elimina los null por si algún producto ya no existe

        //Combina los datos para el dashboard
        $productosCombinados = $productosPropios->concat($productosComprados);
        /*Saca dos colecciones:
        $nombres: etiquetas para el listado
        $cantidades: valores numéricos (stock o cantidad comprada)*/
        $nombres    = $productosCombinados->pluck('nombre');
        $cantidades = $productosCombinados->pluck('cantidad');

        //Devuelve la vista del dashboard
        return view('dashboard', compact('nombres', 'cantidades', 'productosCombinados'));
    }

}
