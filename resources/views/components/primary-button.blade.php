<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-marron-chocolate text-beige-tostado border border-transparent rounded-md font-semibold text-xs text-beige-tostado uppercase tracking-widest hover:bg-oro-antiguo hover:text-marron-chocolate focus:bg-oro-antiguo active:bg-marron-chocolate focus:outline-none focus:ring-2 focus:ring-oro-antiguo focus:ring-offset-2 focus:ring-offset-marron-chocolate transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
