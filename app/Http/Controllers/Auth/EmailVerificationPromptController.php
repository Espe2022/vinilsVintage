<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/*Controlador que decide si debe mostrar el aviso de verificación de email o dejar pasar al usuario 
a su dashboard*/
class EmailVerificationPromptController extends Controller
{
    /**
     * Display the email verification prompt.
     * El método se llama __invoke, así que el controlador se usa como controlador invocable (no necesita nombre de método en la ruta)
     * 
     */
    public function __invoke(Request $request): RedirectResponse|View
    {
        //hasVerifiedEmail() comprueba si el usuario ya verificó su correo
        return $request->user()->hasVerifiedEmail()
                    //Si ya está verificado → lo redirige al dashboard (o a la URL “intended”)
                    ? redirect()->intended(route('dashboard', absolute: false))
                    //Si no está verificado → devuelve la vista auth.verify-email, que es la pantalla que dice “Verifica tu correo” y suele tener un botón para reenviar el enlace
                    : view('auth.verify-email');
    }
}
