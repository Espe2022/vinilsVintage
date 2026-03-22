<?php

namespace App\Http\Controllers\Auth;

//Importa las clases:
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;

//Controlador de verificación de email
class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        //Si ya tiene el email verificado, redirige al dashboard
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(route('dashboard', absolute: false).'?verified=1');
        }

        //Llama markEmailAsVerified() en el modelo User y dispara el evento Verified (para logs, notificaciones, etc.)
        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        //Redirige al dashboard con parámetro ?verified=1
        return redirect()->intended(route('dashboard', absolute: false).'?verified=1');
    }
}
