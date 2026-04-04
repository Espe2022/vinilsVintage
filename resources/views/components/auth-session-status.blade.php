@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'mb-4 text-xl font-semibold text-marron-chocolate bg-oro-antiguo/40 px-4 py-2 rounded-md']) }}>
        {{ $status }}
    </div>
@endif
