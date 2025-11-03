<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dashboard(){
        //obtener todos los productos de un usuario autenticado para hacer el gráfico
        $productos = Producto::where('user_id', Auth::id())->get();

        //preparar los datos para el gráfico de barras
        $nombres = $productos->pluck('nombre');   //array de los productos de la columna nombre
        $cantidades = $productos->pluck('cantidad');  //array de las cantidades

        //pasar los datos a la vista
        return view('dashboard', [
            'nombres' => $nombres,
            'cantidades' => $cantidades
        ]);

    }
}
