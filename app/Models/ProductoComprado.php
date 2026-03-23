<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

//Modelo que representa la tabla 'productos_comprados'
class ProductoComprado extends Model
{
    //Forzar el nombre correcto de la tabla
    protected $table = 'productos_comprados';

    /**
     * Campos que se pueden asignar masivamente
     * Ejemplo: ProductoComprado::create([...])
     */
    protected $fillable = [
        'user_id', 
        'product_id', 
        'cantidad'
    ];

    // ----------------------
    // Relaciones Eloquent
    // ----------------------

    /**
     * Relación: Un registro comprado pertenece a un producto
     * - Cada ProductoComprado tiene una columna product_id
     * - Esto conecta con la tabla productos
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'product_id');
    }

    /**
     * Relación: Un registro comprado pertenece a un usuario
     * - Cada ProductoComprado tiene una columna user_id
     * - Esto conecta con la tabla users
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
