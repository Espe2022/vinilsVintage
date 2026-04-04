@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'font-medium text-xl text-marron-chocolate']) }}>
        {{ $status }}
    </div>
@endif
