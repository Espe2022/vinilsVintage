<?php

//Namespace donde se encuentra esta clase (requests de autenticación)
namespace App\Http\Requests\Auth;

//Importación de clases necesarias
use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;


//Clase que gestiona la validación y autenticación del login
class LoginRequest extends FormRequest
{
    /**
     * Determina si el usuario puede hacer esta petición.
     * Aquí siempre devuelve true → cualquiera puede intentar login.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Reglas de validación del formulario de login.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //El email es obligatorio, debe ser string y formato email
            'email' => ['required', 'string', 'email'],
            //La contraseña es obligatoria
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Intenta autenticar al usuario con las credenciales.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(): void
    {
        //Primero comprueba que no haya demasiados intentos
        $this->ensureIsNotRateLimited();

        //Intenta login con email y password
        if (! Auth::attempt($this->only('email', 'password'), $this->boolean('remember'))) {
            //Si falla, registra un intento fallido
            RateLimiter::hit($this->throttleKey());

            //Lanza error de validación
            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }

        //Si login correcto, limpia el contador de intentos
        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Verifica que no se haya superado el límite de intentos de login.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        //Permite hasta 5 intentos antes de bloquear
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        //Dispara evento de bloqueo
        event(new Lockout($this));

        //Tiempo que falta para poder intentar otra vez
        $seconds = RateLimiter::availableIn($this->throttleKey());

        //Lanza error indicando cuánto tiempo esperar
        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Genera una clave única para limitar intentos:
     * combina email + IP del usuario.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->string('email')).'|'.$this->ip());
    }
}
