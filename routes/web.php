<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductoController;
use App\Models\Producto;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\CompraController;

Route::get('/', function () {
    return view('welcome');
});

// //Sólo muestra el dashboard si está autenticado y verificado
// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');
//La función para devolver la vista desaparece y usamos el controlador DashboardController que es una clase
Route::get('/dashboard', [DashboardController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');

//Acceder a Ver Catálogo (todos los productos)
Route::get('/catalogo', [ProductoController::class, 'catalogo'])->name('catalogo');

//Puede entrar en estas rutas siempre y cuando esté autenticado (Proteger las rutas)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //Ruta de productos ya está protegida (a través del auth)
    //Resource (Contiene todas las rutas necesarias para los métodos de ProductoController)
    Route::resource('productos', ProductoController::class);
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


require __DIR__.'/auth.php';
