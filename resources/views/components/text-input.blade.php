@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'bg-beige-crema border-2 border-marron-chocolate text-marron-chocolate focus:border-oro-antiguo focus:ring-oro-antiguo bg-beige-tostado  placeholder:text-marron-chocolate/70 rounded-md shadow-sm']) }}>
