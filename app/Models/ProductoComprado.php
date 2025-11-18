<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductoComprado extends Model
{
    //Forzar el nombre correcto de la tabla
    protected $table = 'productos_comprados';

    protected $fillable = [
        'user_id', 
        'product_id', 
        'cantidad'
    ];

    /**
     * Definir la relación: Un registro en productos_comprados pertenece a un único registro en la tabla productos (1:1)
     * La clave foránea en la tabla productos_comprados (product_id) que apunta a la clave primaria (id) de la tabla productos
     * 
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'product_id');
    }
}
