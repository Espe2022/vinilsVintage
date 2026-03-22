<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;

//Controlador de Laravel para el “Olvidé mi contraseña”
class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     * Muestra el formulario de “Olvidé mi contraseña” (auth.forgot-password.blade.php), donde 
     * el usuario introduce su email.
     * 
     */
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        /*Valida que el usuario haya enviado un email válido. Si falla, Laravel vuelve atrás 
        mostrando el error en el formulario*/
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        /*Buscar un usuario con ese email.
        Generar un token temporal de restablecimiento.
        Enviar un email con un enlace tipo /reset-password?token=... al usuario.*/
        $status = Password::sendResetLink(
            $request->only('email')
        );

        /*Si el email se envió bien (Password::RESET_LINK_SENT), redirige de vuelta mostrando 
        un mensaje de éxito (por ejemplo “Te hemos enviado el enlace”).
        Si hubo error (email no encontrado, throttling, etc.), redirige de vuelta con el email 
        rellenado y un mensaje de error debajo del campo*/
        return $status == Password::RESET_LINK_SENT
                    ? back()->with('status', __($status))
                    : back()->withInput($request->only('email'))
                        ->withErrors(['email' => __($status)]);
    }
}
