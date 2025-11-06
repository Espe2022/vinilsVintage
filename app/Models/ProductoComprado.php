<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductoComprado extends Model
{
    //Forzar el nombre correcto de la tabla
    protected $table = 'productos_comprados';

    protected $fillable = ['user_id', 'product_id', 'cantidad'];
}
