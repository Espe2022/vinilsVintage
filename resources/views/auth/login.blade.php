<!--Esta vista utiliza componentes Blade para reutilizar estructura y lógica, y está conectada con el 
sistema de autenticación de Laravel mediante rutas, validación y protección CSRF -->

<!-- Layout para usuarios no autenticados (VISITANTES: login, register, etc.) -->
<x-guest-layout>

    <!-- Muestra mensajes de sesión (por ejemplo: login correcto, errores, etc.) -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <!-- Formulario de inicio de sesión -->
    <form method="POST" action="{{ route('login') }}">
        @csrf   <!-- Token de seguridad para evitar ataques CSRF -->

        <!-- Campo de Email -->
        <div>
            <!-- Etiqueta del input -->
            <x-input-label for="email" :value="__('Email')" />

            <!-- Input de email con valor anterior si falla validación -->
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            
            <!-- Muestra errores de validación del email -->
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Campo de contraseña -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <!-- Muestra errores de validación de la contraseña -->
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Checkbox "Recordarme" -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">

                <!-- Checkbox que permite mantener la sesión iniciada -->
                <input id="remember_me" type="checkbox" class="rounded border-marron-chocolate text-marron-chocolate shadow-sm focus:ring-oro-antiguo focus:border-oro-antiguo" name="remember">
                
                <!-- Texto del checkbox -->
                <span class="ms-2 text-sm text-marron-chocolate">{{ __('Remember me') }}</span>
            </label>
        </div>

        <!-- Enlaces y botón de login -->
        <div class="flex items-center justify-end mt-4">

            <!-- Enlace para recuperar contraseña (solo si existe la ruta) -->
            @if (Route::has('password.request'))
                <a class="underline text-sm text-marron-chocolate hover:text-oro-antiguo rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-oro-antiguo" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <!-- Botón de envío del formulario -->
            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>

</x-guest-layout>


<!-- Incluye el footer desde una vista parcial -->
@include('pie.footer')



