<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class ProductoController extends Controller
{
    //Contiene toda la lógica a la app(CRUD)
    
    //Consulta la base de datos y muestra los productos a través de la vista
    public function index(){
        //Consulta a la bd a nuestra tabla productos. Es privado para usuarios autenticados
        $productos=Producto::where('user_id', Auth::id())->paginate(5); //5 productos por página
        return view('productos.index', compact('productos'));
    }

    public function catalogo()
    {
        //Obtener todos los productos disponibles para mostrar al público (es público)
        //$productos = Producto::paginate(4);
        //Mostrar cada vinilo solo una vez (aunque existan varios con el mismo nombre)
        $productos = DB::table('productos')
            ->select(
                DB::raw('MIN(id) as id'),
                'nombre',
                DB::raw('MIN(descripcion) as descripcion'),
                DB::raw('MIN(precio) as precio'),
                DB::raw('MIN(imagen) as imagen')
            )
            ->groupBy('nombre')
            ->paginate(4);

        return view('catalogo', compact('productos'));
    }

    //Redirecciona a una vista de create para mostrar el formulario para crear un producto
    public function create()
    {
        //Trae todos los usuarios y productos de la base de datos
        $users = User::all();
        $productos = Producto::all();  

        //Pasa la variable $productos a la vista
        return view('productos.create', compact('productos'));
    }

    //Guardar un producto en la base de datos
    public function store(Request $request){

        //Validar los campos del formulario por parte del servidor
        $request->validate([
            'nombre'=>'required|string|max:255',
            'descripcion'=>'nullable|string',
            'precio'=>'required|numeric|min:1',
            'cantidad'=>'required|integer|min:1',
        ],[
            //Validar los campos de cantidad requeridos para que salga un mensaje personalizado
            'cantidad.required'=>'La cantidad es obligatoria',
            'cantidad.integer'=>'La cantidad debe ser un número entero',
            'cantidad.min'=>'La cantidad no puede ser menor de 1',
        ]);

        //Lógica para guardar un producto
        Producto::create([
            'user_id'=>Auth::id(),  //El id del usuario autenticado asignarlo a user_id
            'nombre'=>$request->nombre, //El nombre es el contenido del name del formulario
            'descripcion'=>$request->descripcion,
            'precio'=>$request->precio,
            'cantidad'=>$request->cantidad,
            'imagen'=>$request->imagen
        ]);

        //Redirigir a la lista principal (index) con mensaje de éxito
        return redirect()->route('productos.index')->with('success', '¡Producto creado con éxito!');
    }

    //Buscar en la base de datos un producto por su id y se muestra en una vista
    public function show($id){
        //Mostrar un producto específico por su ID, sino lo encuentra, Laravel devuelve automáticamente una página 404
        $producto=Producto::findOrFail($id);
        return view('productos.show', compact('producto'));
    }

    //Buscar en la base de datos un producto por su id y mandarlo a un formulario
    public function edit($id){
        $producto=Producto::findOrFail($id);

        return view('productos.edit', compact('producto'));
    }

    //Actualizar un producto por su id
    public function update(Request $request, $id){
        //Lógica para actualizar

        //Validar los campos del formulario por parte del servidor
        $request->validate([
            'nombre'=>'required|string|max:255',
            'descripcion'=>'nullable|string',
            'precio'=>'required|numeric|min:1',
            'cantidad'=>'required|integer|min:1',
        ],[
            //Validar los campos de cantidad requeridos para que salga un mensaje personalizado
            'cantidad.required'=>'La cantidad es obligatoria',
            'cantidad.integer'=>'La cantidad debe ser un número entero',
            'cantidad.min'=>'La cantidad no puede ser menor de 1',
        ]);

        $producto=Producto::findOrFail($id);

        $producto->update([
            'nombre'=> $request->nombre,
            'descripcion'=>$request->descripcion,
            'precio'=>$request->precio,
            'cantidad'=>$request->cantidad,
        ]);

        //Redirigir a la lista principal (index) con mensaje de éxito
        return redirect()->route('productos.index')->with('success', '¡Producto actualizado con éxito!');
    }

    //Eliminar un producto por su id
    public function destroy($id){
        //Lógica para eliminar
        $producto=Producto::findOrFail($id);
        $producto->delete();

        //Redirigir a la lista principal (index) con mensaje de éxito
        return redirect()->route('productos.index')->with('success', '¡Producto eliminado con éxito!');
    }
}
