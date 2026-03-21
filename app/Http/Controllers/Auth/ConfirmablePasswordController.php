<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

/*Controlador que implementa la pantalla de “confirma tu contraseña para continuar”, 
típica cuando se va a cambiar cosas importantes en la cuenta*/
class ConfirmablePasswordController extends Controller
{
    /**
     * Show the confirm password view.
     * Muestra un formulario donde el usuario ya autenticado introduce de nuevo su contraseña.
     * No es un login nuevo, es una confirmación extra.
     */
    public function show(): View
    {
        return view('auth.confirm-password');
    }

    /**
     * Confirm the user's password.
     */
    public function store(Request $request): RedirectResponse
    {
        //Comprueba que la contraseña escrita coincide con la del usuario logueado
        if (! Auth::guard('web')->validate([
            'email' => $request->user()->email,
            'password' => $request->password,
        ])) {
            //Si es incorrecta, lanza un ValidationException y muestra error en el campo password
            throw ValidationException::withMessages([
                'password' => __('auth.password'),
            ]);
        }

        //Si es correcta, guarda en sesión auth.password_confirmed_at con la hora actual
        $request->session()->put('auth.password_confirmed_at', time());

        //Luego redirige a la página destinada (dashboard u otra que estuviera intentando abrir)
        return redirect()->intended(route('dashboard', absolute: false));
    }
}
