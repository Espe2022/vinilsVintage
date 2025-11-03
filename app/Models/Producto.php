<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    //Indica explícitamente que la tabla de la base de datos 'productos' está asociada al modelo Producto.php
    protected $table='productos';

    /**
     * The attributes that are mass assignable (Los atributos que pueden ser asignados de manera masiva)
     * Al crear un producto, éstos son los campos que puedes rellenar directamente.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nombre',
        'descripcion',
        'precio',
        'cantidad',
        'user_id',
    ];

    /**
     * Definir la relación: Un producto pertenece a un usuario (N:1)
     * 
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
