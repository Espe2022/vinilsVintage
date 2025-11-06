@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-1 pt-1 border-b-2 border-marron-chocolate text-sm font-medium leading-5 text-marron-chocolate focus:outline-none focus:border-marron-chocolate transition duration-150 ease-in-out'
            : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-marron-chocolate hover:text-oro-antiguo hover:border-marron-chocolate focus:outline-none focus:text-marron-chocolate focus:border-marron-chocolate transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
