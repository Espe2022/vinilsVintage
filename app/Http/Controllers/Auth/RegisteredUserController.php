<?php

namespace App\Http\Controllers\Auth;

//Importa las clases que necesita:
use App\Http\Controllers\Controller;
use App\Models\User;    //modelo de usuarios
use Illuminate\Auth\Events\Registered;  //evento que se lanza cuando alguien se registra
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;    //la petición HTTP
use Illuminate\Support\Facades\Auth;    //para iniciar sesión al nuevo usuario
use Illuminate\Support\Facades\Hash;    //para encriptar la contraseña
use Illuminate\Validation\Rules;    //reglas de validación de contraseña
use Illuminate\View\View;

/*Controlador que se encarga de registrar nuevos usuarios, validarlos, guardarlos en la tabla users, 
loguearlos y enviarlos al panel principal*/
class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     * Muestra la vista del formulario de registro (resources/views/auth/register.blade.php).
     * Es la pantalla donde el usuario escribe nombre, email y contraseña.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     * Lógica del registro.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        //Valida los datos
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        //Crea el usuario en la base de datos, encriptando la contraseña con Hash::make
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        //Lanza el evento Registered($user) (enviar email de verificación)
        event(new Registered($user));

        //Inicia sesión automáticamente a ese usuario con Auth::login($user)
        Auth::login($user);

        //Redirige al dashboard (route('dashboard'))
        return redirect(route('dashboard', absolute: false));
    }
}
