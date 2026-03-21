<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

//Controlador que reenvía el correo de verificación de email para un usuario ya registrado y logueado
class EmailVerificationNotificationController extends Controller
{
    /**
     * Send a new email verification notification.
     */
    public function store(Request $request): RedirectResponse
    {
        //hasVerifiedEmail() comprueba si el usuario ya tiene el email verificado
        if ($request->user()->hasVerifiedEmail()) 
        {
            //Si ya está verificado, lo redirige al dashboard (o a la URL “intended”)
            return redirect()->intended(route('dashboard', absolute: false));
        }

        /*Si no está verificado:
        Llama a sendEmailVerificationNotification(), que envía un nuevo email con el enlace de 
        verificación al usuario actual*/
        $request->user()->sendEmailVerificationNotification();

        /*Vuelve a la misma página con un mensaje de estado (por ejemplo, “se ha enviado un nuevo 
        enlace de verificación”)*/
        return back()->with('status', 'verification-link-sent');
    }
}
