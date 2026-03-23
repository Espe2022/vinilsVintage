<?php

//Namespace donde se encuentra esta clase
namespace App\Http\Requests;

//Importa el modelo User (tabla users)
use App\Models\User;
//Clase base para manejar validaciones de formularios
use Illuminate\Foundation\Http\FormRequest;
//Permite reglas avanzadas como unique con excepciones
use Illuminate\Validation\Rule;

//Clase que valida la actualización del perfil del usuario
class ProfileUpdateRequest extends FormRequest
{
    /**
     * Reglas de validación que se aplican al formulario.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //Nombre obligatorio, tipo string y máximo 255 caracteres
            'name' => ['required', 'string', 'max:255'],

            //Email con varias validaciones
            'email' => [
                'required', //obligatorio
                'string',    //debe ser texto
                'lowercase',     //se guarda en minúsculas
                'email',    //formato válido de email
                'max:255',  //máximo 255 caracteres

                //Debe ser único en la tabla users,
                //PERO no comparar con el usuario actual
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
        ];
    }
}
