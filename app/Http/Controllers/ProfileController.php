<?php

namespace App\Http\Controllers;

// ================================
// IMPORTACIONES
// ================================
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

/*
|--------------------------------------------------------------------------
| Controlador de Perfil
|--------------------------------------------------------------------------
|
| Este controlador gestiona todo lo relacionado con el perfil del usuario:
| - Ver datos del perfil
| - Actualizar información
| - Eliminar cuenta
|
*/

class ProfileController extends Controller
{
    /**
     * Mostrar formulario del perfil
     */
    public function edit(Request $request): View
    {
        // Devuelve la vista del perfil con el usuario autenticado
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Actualizar perfil
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        /*
        | fill() → rellena el modelo con los datos validados
        | validated() → obtiene solo los datos que pasaron la validación
        */        
        $request->user()->fill($request->validated());

        /*
        | Si el email ha cambiado:
        | - Se invalida la verificación del correo
        | - Obliga al usuario a verificarlo otra vez
        */
        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        //Guarda los cambios en la base de datos
        $request->user()->save();

        //Redirige a profile.edit con un estado profile-updated (que se puede mostrar en la vista como mensaje de éxito)
        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

     /**
     * Eliminar cuenta
     */
    public function destroy(Request $request): RedirectResponse
    {
        /*
        | Validación de seguridad:
        | El usuario debe introducir su contraseña actual.
        |
        | Valida que el usuario ponga su contraseña actual (current_password) antes de borrar 
        | la cuenta, y guarda posibles errores en el bag userDeletion (para mostrarlos separados 
        | en el formulario).
        */
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        // Obtener usuario actual
        $user = $request->user();

        // Cerrar sesión
        Auth::logout();

        // Eliminar usuario de la base de datos
        $user->delete();

        /*
        | Seguridad de sesión:
        | - Invalida sesión
        | - Regenera token CSRF
        */
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        //Redirige a la home /
        return Redirect::to('/');
    }
}

/*
Este controlador gestiona el perfil del usuario, permitiendo editar sus datos, actualizarlos con 
validación y eliminar la cuenta de forma segura.

Permite que los usuarios gestionen su cuenta dentro de la tienda de vinilos, incluyendo actualizar 
sus datos o eliminar su perfil.

ProfileUpdateRequest    Es una clase de validación personalizada que separa la lógica de validación 
del controlador para mantener el código limpio y escalable.

fill()  Rellena el modelo con los datos del formulario.

isDirty()   Comprueba si un campo ha cambiado antes de guardarlo.

email_verified_at = null    Para obligar a verificar el correo si el usuario lo modifica.

Auth::logout()  Cierra la sesión del usuario.

Por seguridad, antes de eliminar la cuenta se pide la contraseña actual, lo que evita eliminaciones 
accidentales o maliciosas.

*/
