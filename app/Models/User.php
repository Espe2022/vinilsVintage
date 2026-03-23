<?php

/*Un namespace (o espacio de nombres) es una forma de organizar y agrupar clases, funciones y constantes para 
evitar conflictos de nombres.*/
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Modelo User
 * - Hereda de Authenticatable → permite login/autenticación
 * - Organiza usuarios de la aplicación
 */
class User extends Authenticatable
{
    use Notifiable; //Para enviar notificaciones al usuario
    use HasFactory; //Para usar factories y crear usuarios de prueba fácilmente

    /**
     * Atributos que se pueden asignar masivamente
     * Al crear un usuario, éstos son los campos que puedes rellenar directamente
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role'
    ];

    /**
     * Atributos ocultos cuando serializamos el modelo (JSON, arrays)
     * 
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Atributos que se convierten automáticamente
     * - email_verified_at → datetime
     * - password → hashed automáticamente
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',  //Se convierte a tipo fecha
            'password' => 'hashed', //Se guarda automáticamente hasheado (seguro)
        ];
    }

    // ----------------------
    // Relaciones
    // ----------------------

    /**
     * Relación: Un usuario puede tener muchos productos (1:N)
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function productos()
    {
        return $this->hasMany(Producto::class);     
    }
  
    /**
     * Definir la relación: Un usuario puede tener un carrito (1:1)
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function carritos()
    {
        return $this->hasOne(Carrito::class);
    }

    /**
     * Relación: Un usuario puede tener muchos productos comprados (1:N)
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function productosComprados()
    {
        return $this->hasMany(ProductoComprado::class);
    }

    // ----------------------
    // Mutators / Métodos
    // ----------------------
    
    /**
     * Mutator: Convierte automáticamente el email a minúsculas antes de guardarlo
     */
    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = strtolower($value);
    }

    /**
     * Método de conveniencia: Comprueba si el usuario es administrador
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

}





