<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

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
        'imagen',
        'user_id',
        'categoria',
        'stock' 
    ];

    /**
     * Definir la relación: Un producto pertenece a un usuario (1:1)
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Definir la relación: Un producto puede estar en varios carritos (1:N)
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function carritos()
    {
        return $this->hasMany(Carrito::class);
    }

    /**
     * Definir la relación: Un producto puede estar en varias compras (1:N)
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function productosComprados()
    {
        return $this->hasMany(ProductoComprado::class);
    }
}
