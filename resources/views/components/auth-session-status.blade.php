@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'mb-4 inline-block mx-auto text-lg font-semibold text-marron-chocolate bg-[#f5efe3] border border-[#c9a96b] border-l-[5px] border-l-[#b08d57] rounded-lg shadow-sm px-4 py-2']) }}>
        {{ $status }}
    </div>
@endif
