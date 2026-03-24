<?php

namespace App\Http\Controllers;

// ================================
// IMPORTACIONES
// ================================
use App\Models\Producto;
use App\Models\ProductoComprado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| Controlador del Dashboard
|--------------------------------------------------------------------------
|
| Este controlador construye los datos necesarios para mostrar el panel
| principal (dashboard) de la aplicación.
|
| Muestra:
| - Productos del usuario (o todos si es admin)
| - Historial de compras
| - Datos combinados para visualización (listados)
|
*/

class DashboardController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Mostrar dashboard
    |--------------------------------------------------------------------------
    */
    public function dashboard()
    {
        //Obtener usuario autenticado
        $user = Auth::user();

        /*
        |--------------------------------------------------------------------------
        | Obtener productos
        |--------------------------------------------------------------------------
        |
        | - Si es admin → obtiene todos los productos
        | - Si es usuario → solo sus productos
        |
        */
        $productos = $user->isAdmin()
            ? Producto::all()
            : Producto::where('user_id', $user->id)->get();

        /*
        |--------------------------------------------------------------------------
        | Transformar productos propios
        |--------------------------------------------------------------------------
        |
        | Se mapean a un formato simple para mostrar en el dashboard:
        | - nombre (con fecha)
        | - cantidad (stock)
        |
        */
        $productosPropios = $productos->map(function($producto){

            // Formatear fecha de creación
            $fecha = $producto->created_at
                ? $producto->created_at->format('d/m/Y')
                : now()->format('d/m/Y');

            return [
                // Nombre del producto + fecha
                'nombre'   => $producto->nombre . ' (' . $fecha . ')',
                
                // Stock disponible
                'cantidad' => $producto->stock,
            ];
        });

        /*
        |--------------------------------------------------------------------------
        | Obtener historial de compras
        |--------------------------------------------------------------------------
        |
        | - Admin → ve todas las compras
        | - Usuario → solo sus compras
        |
        */
        $compras = $user->isAdmin()
            ? ProductoComprado::orderBy('created_at', 'asc')->get()
            : ProductoComprado::where('user_id', $user->id)
                ->orderBy('created_at', 'asc')
                ->get();

        /*
        |--------------------------------------------------------------------------
        | Transformar compras
        |--------------------------------------------------------------------------
        |
        | Se convierten en formato:
        | - nombre (producto + fecha de compra)
        | - cantidad comprada
        |
        */
        $productosComprados = $compras->map(function($compra) {

            // Buscar el producto asociado
            $producto = Producto::find($compra->product_id);

            if ($producto) {

                // Formatear fecha de compra
                $fecha = $compra->created_at
                    ? $compra->created_at->format('d/m/Y')
                    : now()->format('d/m/Y');

                return [
                    'nombre'   => $producto->nombre . ' (' . $fecha . ')',
                    'cantidad' => $compra->cantidad,
                ];
            }
        })
        //Eliminar valores null si algún producto ya no existe
        ->filter();  

        /*
        |--------------------------------------------------------------------------
        | Combinar datos
        |--------------------------------------------------------------------------
        |
        | Se unen:
        | - Productos propios
        | - Productos comprados
        |
        */
        $productosCombinados = $productosPropios->concat($productosComprados);
        
        /*
        |--------------------------------------------------------------------------
        | Preparar datos para la vista
        |--------------------------------------------------------------------------
        |
        | Se separan en:
        | - nombres → etiquetas
        | - cantidades → valores numéricos
        |
        */
        $nombres    = $productosCombinados->pluck('nombre');
        $cantidades = $productosCombinados->pluck('cantidad');

        /*
        |--------------------------------------------------------------------------
        | Retornar vista
        |--------------------------------------------------------------------------
        */
        return view('dashboard', compact('nombres', 'cantidades', 'productosCombinados'));
    }
}

/*
Este controlador demuestra lógica de datos + roles (admin/usuario) + transformación de datos.

Este controlador genera los datos del dashboard, diferenciando entre usuarios normales y administradores, 
y transformando la información para poder representarla en la interfaz, por ejemplo en listado.

El dashboard permite ver un resumen de la actividad, como productos disponibles y compras realizadas, 
lo que ayuda a gestionar la tienda.

Control de roles (isAdmin())    Permite mostrar distintos datos según el tipo de usuario.

Uso de map()    Transforma los datos para adaptarlos a la vista sin modificar la base de datos.

Uso de pluck()  Extrae valores concretos para representarlos en listados.

Combinación de datos    Une productos y compras en una sola colección para mostrar información global.