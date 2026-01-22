<?php

/*Un namespace (o espacio de nombres) es una forma de organizar y agrupar clases, funciones y constantes para 
evitar conflictos de nombres.*/
namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/*La clase User hereda de Authenticatable para que este modelo pueda autenticarse (LOGIN: un usuario puede 
iniciar sesión)*/
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use Notifiable; //Para enviar notificaciones al usuario
    use HasFactory; //Para usar factories y crear usuarios de prueba fácilmente

    /**
     * The attributes that are mass assignable (Los atributos que pueden ser asignados de manera masiva)
     * Al crear un usuario, éstos son los campos que puedes rellenar directamente.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization (Los atributos que deben ser ocultados durante la serialización).
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast (Obtener los atributos que deben ser convertidos (casteados)).
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
    
    //Mutator para email: Laravel automáticamente convierte el email a minúsculas antes de guardarlo en la base de datos
    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = strtolower($value);
    }
}





