<!--Formulario de registro que conecta frontend + validación + autenticación
Este formulario está conectado con el sistema de autenticación de Laravel y utiliza validación en 
backend, componentes Blade y protección CSRF para garantizar seguridad y reutilización de código -->

<!-- Layout para usuarios no autenticados -->
<x-guest-layout>

    <!-- Formulario de registro de usuario -->
    <form method="POST" action="{{ route('register') }}">
        @csrf   <!-- Token de seguridad contra ataques CSRF -->

        <!-- Campo Nombre -->
        <div>
            <!-- Etiqueta del input -->
            <x-input-label for="name" :value="__('Name')" class="text-marron-chocolate"/>

            <!-- Input de nombre con persistencia de datos si falla validación -->
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            
            <!-- Muestra errores de validación -->
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Campo Email -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" class="text-marron-chocolate"/>
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            
            <!-- Errores del email -->
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Campo Contraseña -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" class="text-marron-chocolate"/>

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <!-- Errores de contraseña -->
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirmación de contraseña -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-marron-chocolate"/>

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <!-- Errores de confirmación -->
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Enlace a login + botón de registro -->
        <div class="flex items-center justify-end mt-4">

            <!-- Enlace para usuarios ya registrados -->
            <a class="underline text-sm text-marron-chocolate hover:text-oro-antiguo rounded-md focus:ring-2 focus:ring-offset-0 focus:outline-none focus:ring-oro-antiguo" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <!-- Botón para enviar el formulario -->
            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>

</x-guest-layout>

<!-- Inclusión del footer -->
@include('pie.footer')



