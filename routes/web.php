<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductoController;
use App\Models\Producto;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\CompraController;
use App\Http\Middleware\AdminMiddleware;

// Ruta de bienvenida (página principal)
Route::get('/', function () {
    return view('welcome');
});

// Dashboard: solo para usuarios autenticados y verificados, usamos el controlador DashboardController
Route::get('/dashboard', [DashboardController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');

// Catálogo público: mostrar todos los productos
Route::get('/catalogo', [ProductoController::class, 'catalogo'])->name('catalogo');

// Rutas de perfil: protegidas, solo usuarios autenticados
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Rutas de carrito y compras: solo usuarios autenticados
Route::middleware('auth')->group(function () {
    // Carrito
    //Index muestra los productos en el carrito
    Route::get('/carrito', [CarritoController::class, 'index'])->name('carrito.index');
    //El controlador store añade el producto al carrito
    Route::post('/carrito/agregar/{id}', [CarritoController::class, 'store'])->name('carrito.agregar');
    //Destroy elimina el producto del carrito
    Route::delete('/carrito/eliminar/{id}', [CarritoController::class, 'destroy'])->name('carrito.eliminar');
    //Actualizar cantidad de un producto en el carrito
    Route::put('/carrito/actualizar/{id}', [CarritoController::class, 'update'])->name('carrito.update');

    // Compras
    Route::post('/comprar', [CompraController::class, 'comprar'])->name('comprar');
});

// Rutas de productos: solo usuarios admin
Route::middleware(['auth', AdminMiddleware::class])->group(function () {
    Route::resource('productos', ProductoController::class);    // CRUD completo de productos
});

// Ruta de búsqueda de productos (por nombre o categoría)
Route::get('/buscar', [ProductoController::class, 'buscar'])->name('productos.buscar');

// Rutas de autenticación generadas por Laravel Breeze / Jetstream
require __DIR__.'/auth.php';
