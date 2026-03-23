<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

//Modelo Carrito que representa la tabla 'carritos' en la base de datos
class Carrito extends Model
{
    use HasFactory;  //Permite usar fábricas para pruebas o seeders

    /**
     * Campos que se pueden rellenar masivamente (mass assignment)
     * Ejemplo: Carrito::create(['user_id'=>1, 'producto_id'=>2, 'cantidad'=>3])
     */
    protected $fillable = [
        'user_id',
        'producto_id',
        'cantidad',
    ];

    // ----------------------
    // Relaciones Eloquent
    // ----------------------

     /**
     * Relación: Un carrito pertenece a un producto
     * - Cada Carrito tiene una columna producto_id
     * - Esto conecta Carrito con la tabla productos
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }

    /**
     * Relación: Un carrito pertenece a un usuario
     * - Cada Carrito tiene una columna user_id
     * - Esto conecta Carrito con la tabla users
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
