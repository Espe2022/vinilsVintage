@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'font-medium text-lg text-marron-chocolate']) }}>
        {{ $status }}
    </div>
@endif
