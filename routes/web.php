<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductoController;
use App\Models\Producto;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// //Sólo muestra el dashboard si está autenticado y verificado
// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');
//La función para devolver la vista desaparece y usamos el controlador DashboardController que es una clase
Route::get('/dashboard', [DashboardController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');

//Acceder a Ver Catálogo (todos los productos) sin iniciar sesión de usuario
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


require __DIR__.'/auth.php';
