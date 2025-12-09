<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductoController;
use App\Models\Producto;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\CompraController;
use App\Http\Middleware\AdminMiddleware;


Route::get('/', function () {
    return view('welcome');
});

//Sólo muestra el dashboard si está autenticado y verificado, usamos el controlador DashboardController que es una clase
Route::get('/dashboard', [DashboardController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');

//Acceder a Ver Catálogo (todos los productos)
Route::get('/catalogo', [ProductoController::class, 'catalogo'])->name('catalogo');

//Puede entrar en estas rutas siempre y cuando esté autenticado (Proteger las rutas)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//Solo los usuarios logueados pueden acceder a estas rutas (middleware de autenticación)
Route::middleware('auth')->group(function () {
    //Index muestra los productos en el carrito
    Route::get('/carrito', [CarritoController::class, 'index'])->name('carrito.index');
    //El controlador store añade el producto al carrito
    Route::post('/carrito/agregar/{id}', [CarritoController::class, 'store'])->name('carrito.agregar');
    //Destroy elimina el producto del carrito
    Route::delete('/carrito/eliminar/{id}', [CarritoController::class, 'destroy'])->name('carrito.eliminar');

    //Finalizar compras
    Route::post('/comprar', [CompraController::class, 'comprar'])->name('comprar');
});

//Sólo los usuarios admin pueden acceder a las rutas de productos (index, create, edit, etc.)
Route::middleware(['auth', AdminMiddleware::class])->group(function () {
    Route::resource('productos', ProductoController::class);
});

//Ruta para búsqueda de discos por género o nombre del cantante
Route::get('/buscar', [ProductoController::class, 'buscar'])->name('productos.buscar');

require __DIR__.'/auth.php';
