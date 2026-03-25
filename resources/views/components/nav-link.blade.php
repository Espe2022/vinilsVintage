{{-- 
    Componente Blade reutilizable para enlaces de navegación.
    Recibe una propiedad "active" para saber si está activo.
--}}
@props(['active'])

@php
// Se definen las clases CSS dinámicamente según si el enlace está activo o no
$classes = ($active ?? false)
            // Estilo cuando el enlace está activo
            ? 'inline-flex items-center px-1 pt-1 border-b-2 border-marron-chocolate text-sm font-medium leading-5 text-marron-chocolate focus:outline-none focus:border-marron-chocolate transition duration-150 ease-in-out'
            
            // Estilo cuando NO está activo
            : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-marron-chocolate hover:text-oro-antiguo hover:border-marron-chocolate focus:outline-none focus:text-marron-chocolate focus:border-marron-chocolate transition duration-150 ease-in-out';
@endphp

{{-- 
    Se renderiza un enlace <a> con las clases generadas dinámicamente.
    $attributes permite añadir atributos adicionales desde fuera (ej: href)
--}}
<a {{ $attributes->merge(['class' => $classes]) }}>
    
    {{-- 
        $slot representa el contenido que se pasa al componente 
        (por ejemplo: "Dashboard", "Productos", etc.)
    --}}
    {{ $slot }}
</a>
