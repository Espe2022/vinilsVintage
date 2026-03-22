<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

//Controlador que gestiona el editar, actualizar y borrar la cuenta de usuario (el perfil)
class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     * Muestra el formulario del perfil.
     * 
     */
    public function edit(Request $request): View
    {
        //Carga la vista profile.edit
        return view('profile.edit', [
            //Le pasa el usuario autenticado ($request->user())
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     * Actualiza los datos del perfil.
     * Usa un Form Request ProfileUpdateRequest que ya valida nombre, email, etc.
     * 
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        //fill($request->validated()) rellena el modelo User con los campos validados
        $request->user()->fill($request->validated());

        /*isDirty('email') comprueba si el email ha cambiado; si sí, pone 
        email_verified_at = null para obligar a verificar de nuevo el correo*/
        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        //Guarda el usuario
        $request->user()->save();

        //Redirige a profile.edit con un estado profile-updated (que se puede mostrar en la vista como mensaje de éxito)
        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     * Borra la cuenta de usuario.
     * 
     */
    public function destroy(Request $request): RedirectResponse
    {
        /*Valida que el usuario ponga su contraseña actual (current_password) antes de borrar 
        la cuenta, y guarda posibles errores en el bag userDeletion (para mostrarlos separados 
        en el formulario)*/

        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        //Guarda el usuario actual, cierra la sesión (Auth::logout())
        $user = $request->user();

        Auth::logout();

        //Borra el registro del usuario ($user->delete())
        $user->delete();

        //Invalida la sesión y regenera el token CSRF
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        //Redirige a la home /
        return Redirect::to('/');
    }
}
