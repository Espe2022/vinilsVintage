<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carrito extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'producto_id',
        'cantidad',
    ];

    //Relaciones
    /**
     * Definir la relación: El carrito pertenece a un producto (1:1)
     * El modelo Carrito tiene una columna producto_id que apunta a la tabla productos
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }

    /**
     * Definir la relación: El carrito pertenece a un usuario (1:1)
     * Existe una columna user_id en la tabla carritos que apunta a la tabla users
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
