<?php

//Indica que la clase pertenece al espacio de nombres de controladores de Laravel
namespace App\Http\Controllers; 

// ================================
// IMPORTACIONES
// ================================
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| Controlador de Productos
|--------------------------------------------------------------------------
|
| Este controlador gestiona toda la lógica relacionada con los productos
| (vinilos) de la tienda:
|
| - CRUD completo (crear, leer, actualizar, eliminar)
| - Catálogo general
| - Búsqueda de productos
|
*/

class ProductoController extends Controller
{    
    /*
    |--------------------------------------------------------------------------
    | Mostrar productos del usuario
    |--------------------------------------------------------------------------
    | Consulta la base de datos y muestra los productos a través de la vista
    |
    */
    public function index()
    {
        // Obtiene solo los productos del usuario autenticado
        // paginate(5) → divide los resultados en páginas de 5 productos
        $productos=Producto::where('user_id', Auth::id())->paginate(5); //5 productos por página
        
        //Devuelve la vista productos.index con los productos
        return view('productos.index', compact('productos'));
    }

    /*
    |--------------------------------------------------------------------------
    | Mostrar catálogo general
    |--------------------------------------------------------------------------
    */    
    public function catalogo()
    {
        /*Agrupa por nombre y selecciona un mínimo de id, descripcion, precio, imagen (básicamente 
        una “versión” de cada producto)*/
        $productos = DB::table('productos')
            ->select(
                DB::raw('MIN(id) as id'),
                'nombre',
                DB::raw('MIN(descripcion) as descripcion'),
                DB::raw('MIN(precio) as precio'),
                DB::raw('MIN(imagen) as imagen')
            )
            ->groupBy('nombre')
            ->paginate(4);   //pagina de 4 en 4

        //Devuelve la vista catalogo. compact = genera el array ('productos' => $productos)
        return view('catalogo', compact('productos'));
    }

    /*
    |--------------------------------------------------------------------------
    | Mostrar formulario de creación
    |--------------------------------------------------------------------------
    */
    public function create()
    {
        //Recupera todos los productos de la base de datos
        $productos = Producto::all();  

        //Devuelve la vista productos.create
        return view('productos.create', compact('productos'));
    }

     /*
    |--------------------------------------------------------------------------
    | Guardar nuevo producto
    |--------------------------------------------------------------------------
    | Request $request es la forma objeto de Laravel que se usa para leer y manejar la petición 
    | que llega al servidor (formularios, filtros de búsqueda,...).
    |
    */
    public function store(Request $request)
    {
        //Valida los campos del formulario por parte del servidor
        $request->validate([
            'nombre'=>'required|string|max:255',
            'descripcion'=>'nullable|string',
            'precio'=>'required|numeric|min:1',
            'categoria'=>'required|string',
            'stock'=>'required|integer|min:1',
            'imagen'=>'required|url',
        ],
        );

        /*Crear producto en la base de datos: Lógica para guardar un producto: Crea un nuevo registro 
        en la tabla productos con Producto::create([...]), asignando user_id al id del usuario logueado*/
        Producto::create([
            'user_id'=>Auth::id(),  //El id del usuario autenticado asignarlo a user_id
            'nombre'=>$request->nombre, //El nombre es el contenido del name del formulario
            'descripcion'=>$request->descripcion,
            'precio'=>$request->precio,
            'imagen'=>$request->imagen,
            'categoria'=>$request->categoria,
            'stock'=>$request->stock
        ]);

        //Redirigir a la lista principal (index) con un mensaje de éxito
        return redirect()->route('productos.index')->with('success', '¡Producto creado con éxito!');
    }

    /*
    |--------------------------------------------------------------------------
    | Mostrar un producto
    |--------------------------------------------------------------------------
    | Buscar en la base de datos un producto por su id y se muestra en una vista.
    |
    */
    public function show($id){

        /*findOrFail es un método de Eloquent (Laravel) que se usa para buscar un registro por su ID,
        sino lo encuentra, Laravel devuelve automáticamente un error 404*/
        $producto=Producto::findOrFail($id);

        //Muestra la vista productos.show
        return view('productos.show', compact('producto'));
    }

    /*
    |--------------------------------------------------------------------------
    | Mostrar formulario de edición
    |--------------------------------------------------------------------------
    | Buscar en la base de datos un producto por su id y mandarlo a un formulario.
    |
    */
    public function edit($id){
        
        /*findOrFail es un método de Eloquent (Laravel) que se usa para buscar un registro por su ID,
        sino lo encuentra, Laravel devuelve automáticamente un error 404*/
        $producto=Producto::findOrFail($id);

        //Muestra la vista productos.edit con el formulario de edición
        return view('productos.edit', compact('producto'));
    }

    /*
    |--------------------------------------------------------------------------
    | Actualizar producto
    |--------------------------------------------------------------------------
    | Lógica para actualizar un producto por su id.
    | 
    */
    public function update(Request $request, $id)
    {
        //Valida los campos del formulario recibidos por parte del servidor
        $request->validate([
            'nombre'=>'required|string|max:255',
            'descripcion'=>'nullable|string',
            'precio'=>'required|numeric|min:1',
            'categoria'=>'required|string',
            'stock'=>'required|integer|min:0',
        ],
        );

        //Busca el producto en la base de datos con findOrFail($id)
        $producto=Producto::findOrFail($id);

        //Actualiza el producto con los datos del formulario
        $producto->update([
            'nombre'=> $request->nombre,
            'descripcion'=>$request->descripcion,
            'precio'=>$request->precio,
            'categoria'=>$request->categoria,
            'stock'=>$request->stock
        ]);

        //Redirige al listado de productos (index) con un mensaje de éxito
        return redirect()->route('productos.index')->with('success', '¡Producto actualizado con éxito!');
    }

    /*
    |--------------------------------------------------------------------------
    | Buscar productos
    |--------------------------------------------------------------------------
    | Buscar discos por categoría o nombre.
    |
    */
    public function buscar(Request $request)
    {
        //Lee el término de búsqueda ($buscar)
        $buscar = $request->input('buscar');

        //Si no se escribió nada en el buscador, vuelve al catálogo normal
        if (!$buscar)
        {
            return redirect()->route('catalogo');
        }

        /*Hace una consulta a Producto buscando por categoria o nombre con LIKE "%texto%" 
        y pagina de 4 en 4*/
        $productos = Producto::where('categoria', 'LIKE', "%$buscar%")
                            ->orWhere('nombre', 'LIKE', "%$buscar%")
                            ->paginate(4); 

        //Mantener la búsqueda en la paginación
        $productos->appends(['buscar' => $buscar]);

        //Devuelve la vista catalogo con los resultados y el texto que se escribió en el input de búsqueda
        return view('catalogo', compact('productos', 'buscar'));
    }

    /*
    |--------------------------------------------------------------------------
    | Eliminar producto
    |--------------------------------------------------------------------------
    | Lógica para eliminar un producto por su id.
    |
    */
    public function destroy($id)
    {
        //Busca el producto por id (findOrFail)
        $producto=Producto::findOrFail($id);

        //Llama a $producto->delete() para eliminarlo de la base de datos
        $producto->delete();

        //Redirige a la lista principal (index) con un mensaje de éxito
        return redirect()->route('productos.index')->with('success', '¡Producto eliminado con éxito!');
    }
}

/*
Este controlador gestiona toda la lógica de los productos, incluyendo el CRUD completo, el catálogo 
público y la funcionalidad de búsqueda.

Este controlador permite gestionar los vinilos de la tienda, desde su creación hasta su visualización 
en el catálogo y su búsqueda por categoría o nombre.

He separado claramente la lógica de negocio en el controlador y la visualización en las vistas, 
siguiendo el patrón MVC que utiliza Laravel.

Uso paginate()     Para mejorar el rendimiento y la experiencia del usuario dividiendo los resultados 
en páginas.

Diferencia entre Eloquent y DB::table   Eloquent es un ORM orientado a objetos, mientras que DB::table es 
un query builder más directo. Uso DB::table en el catálogo para hacer agrupaciones más específicas.

Eloquent ORM (Object Relational Mapping) es una herramienta de Laravel que permite interactuar con la base de datos usando clases y 
objetos en lugar de consultas SQL. 
Eloquent es la forma de acceder a la base de datos en Laravel usando objetos en vez de SQL 
(ej: Producto::all();).

FindOrFail()    Busca por ID y si no existe lanza automáticamente un error 404.

Validate()      Para validar los datos en el servidor y evitar datos incorrectos o inseguros.

LIKE    Permite buscar coincidencias parciales en la base de datos.

*/