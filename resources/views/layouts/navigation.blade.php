<nav x-data="{ open: false }" class="bg-beige-tostado border-b border-oro-antiguo">

    <!-- Inicialización de Alpine.js para controlar el menú responsive -->
    <!-- Primary Navigation Menu (Menú principal) -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">

                <!-- Zona izquierda: logo + navegación -->
                <div class="shrink-0 flex items-center">

                    <!-- Logo de la aplicación -->
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-marron-chocolate" />
                    </a>
                </div>

                <!-- Navigation Links (Enlaces de navegación (solo en escritorio)) -->
                <div class= "hidden space-x-8 sm:-my-px sm:ms-10 sm:flex text-marron-chocolate">
                    <!-- Enlace al dashboard -->
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    {{-- 
                        Enlace visible solo para administradores (CRUD)
                        Se comprueba autenticación y rol del usuario.
                    --}}
                    @auth
                        @if (Auth::user()->role === 'admin')
                            <x-nav-link :href="route('productos.index')" :active="request()->routeIs('productos.*')">
                            Productos    
                            </x-nav-link>
                        @endif
                    @endauth

                    <!-- Enlace al catálogo -->
                    <x-nav-link :href="route('catalogo')" :active="request()->routeIs('catalogo')">
                        {{ __('Catálogo') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Menú desplegable de usuario (escritorio) -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">

                <x-dropdown align="right" width="48">

                    <!-- Botón que abre el dropdown -->
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-oro-antiguo text-sm leading-4 font-medium rounded-md text-marron-chocolate bg-beige-crema hover:text-oro-antiguo focus:outline-none transition ease-in-out duration-150">
                        
                        <!-- Nombre del usuario -->
                        <div>{{ Auth::user()->name }}</div>

                            <!-- Icono flecha -->
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <!-- Opciones del usuario -->
                    <x-slot name="content">

                        <!-- Acceso al perfil -->
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        {{-- 
                            Logout seguro mediante POST.
                            Se evita usar GET por seguridad.
                        --}}
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Botón hamburguesa (solo móvil) -->
            <div class="-me-2 flex items-center sm:hidden">
               
                <!-- Cambia estado open para mostrar/ocultar menú -->
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                
                <!-- Iconos dinámicos -->
                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <!-- Icono menú -->
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        
                        <!-- Icono cerrar -->
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu (Menú responsive (móvil))-->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">

        <!-- Enlaces en versión móvil -->
        <div class="pt-2 pb-3 space-y-1">

            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

            {{-- Control de acceso también aplicado en móvil --}}
            @auth
                @if (Auth::user()->role === 'admin')
                    <x-responsive-nav-link :href="route('productos.index')" :active="request()->routeIs('productos.*')">
                        {{ __('Productos') }}
                    </x-responsive-nav-link>
                @endif
            @endauth
            
            <x-responsive-nav-link :href="route('catalogo')" :active="request()->routeIs('catalogo')">
                {{ __('Catálogo') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options (Información del usuario) -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-marron-chocolate">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-marron-chocolate">{{ Auth::user()->email }}</div>
            </div>

            <!-- Opciones usuario -->
            <div class="mt-3 space-y-1">

                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>
                
                {{-- Logout en versión móvil --}}
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>

