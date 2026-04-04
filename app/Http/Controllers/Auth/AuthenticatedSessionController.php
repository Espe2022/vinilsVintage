<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

//Controlador que se encarga de mostrar el login, procesar el inicio de sesión y cerrar sesión
class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     * Muestra la vista del formulario de login (auth.login).
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     * Recibe una LoginRequest (Form Request) que valida email/contraseña y tiene el método authenticate().
     * 
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        //Intenta loguear al usuario con las credenciales que vienen del formulario
        $request->authenticate();

        //Previene ataques de fijación de sesión cambiando el ID de sesión del usuario por uno nuevo
        $request->session()->regenerate();

        //Redirige al dashboard con mensaje de Bienvenida
        return redirect()->intended(route('dashboard', absolute: false))
                ->with('status', 'Bienvenido de nuevo.');
    }

    /**
     * Destroy an authenticated session.
     * Cierra la sesión de un usuario, no borra la cuenta del usuario.
     */
    public function destroy(Request $request): RedirectResponse
    {
        //Hace el logout del usuario actual
        Auth::guard('web')->logout();

        //Invalida toda la sesión 
        $request->session()->invalidate();

        //Genera un nuevo token CSRF por seguridad
        $request->session()->regenerateToken();

        //Redirige a la página de inicio /
        return redirect('/');
    }
}
