<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

/*Controlador sirve para que un usuario ya logueado cambie su contraseña desde su perfil, 
no para “olvidé mi contraseña” sino que quiere cambiarla”*/
class PasswordController extends Controller
{
    /**
     * Update the user's password.
     */
    public function update(Request $request): RedirectResponse
    {
        /*Valida los campos y, si hay errores, los guarda en el error bag llamado updatePassword 
        (útil cuando tienes varios formularios en la misma página)*/
        $validated = $request->validateWithBag('updatePassword', [
            //Debe coincidir con la contraseña actual del usuario 
            'current_password' => ['required', 'current_password'],
            /*Debe cumplir las reglas por defecto (Password::defaults())
            y debe estar confirmada (password_confirmation)*/
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        /*Si pasa la validación:
        Obtiene al usuario actual con $request->user() y actualiza su password en la BD usando 
        Hash::make*/
        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        //Vuelve a la misma página con un mensaje de éxito
        return back()->with('status', 'password-updated');
    }
}
