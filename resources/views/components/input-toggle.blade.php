@props(['size' => 'md'])
@php
    $labelClasses = match ($size) {
        'sm' => 'h-5 w-8',
        'md' => 'h-7 w-12',
    };
    $spanClasses = match ($size) {
        'sm' => 'size-3 peer-checked:start-3',
        'md' => 'size-5 peer-checked:start-5',
    };
@endphp
<label
    for="{{ $attributes->get('id') ?? $attributes->get('name', '') }}"
    class="relative inline-block cursor-pointer rounded-full bg-gray-300 transition [-webkit-tap-highlight-color:_transparent] has-[:checked]:bg-tangerine-500 {{ $labelClasses }}"
>
    <input
        type="checkbox"
        class="peer sr-only"
        {{ $attributes }}
    />
    <span class="absolute inset-y-0 start-0 m-1  rounded-full bg-white transition-all {{ $spanClasses }}"></span>
</label>
