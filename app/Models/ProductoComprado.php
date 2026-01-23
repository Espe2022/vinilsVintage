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
     * Un registro en productos_comprados pertenece a un producto
     * (Un producto puede aparecer en muchos productos_comprados: 1:N)
     * La clave foránea en la tabla productos_comprados (product_id) que apunta a la clave primaria (id) de la tabla productos
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'product_id');
    }

    /**
     * Un producto comprado pertenece a un usuario
     * (Un usuario puede tener muchos productos comprados: 1:N)
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
