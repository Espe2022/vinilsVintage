<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

//Controlador que gestiona el “he olvidado mi contraseña” en la fase de poner la nueva contraseña
class NewPasswordController extends Controller
{
    /**
     * Display the password reset view.
     * Muestra el formulario donde el usuario escribe la nueva contraseña, accediendo desde el 
     * enlace que le llega por email.
     * 
     */
    public function create(Request $request): View
    {
        //Pasa el Request a la vista porque ahí viene el token y el email en la URL
        return view('auth.reset-password', ['request' => $request]);
    }

    /**
     * Handle an incoming new password request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        /*Valida:
        Que venga el token (el que estaba en el email)
        Que el email tenga formato correcto
        Que la contraseña se confirme y cumpla las reglas por defecto*/
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        //Llama a Password::reset(...):
        $status = Password::reset(
            //Verifica que el token y el email son válidos
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user) use ($request) {
                /*Si todo va bien, ejecuta el callback:
                Actualiza la contraseña del User en la BD (Hash::make).
                Genera un nuevo remember_token (para invalidar “recuérdame” antiguos)*/
                $user->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();

                //Lanza el evento PasswordReset
                event(new PasswordReset($user));
            }
        );

        //Si el reseteo fue correcto (Password::PASSWORD_RESET), redirige al login con un mensaje de éxito
        return $status == Password::PASSWORD_RESET
                    ? redirect()->route('login')->with('status', __($status))
                    //Si hubo error (token caducado, email no coincide,...), vuelve al formulario con el email repoblado y un mensaje de error
                    : back()->withInput($request->only('email'))
                        ->withErrors(['email' => __($status)]);
    }
}
