@props(['target' => true])
@php
    if ($slot->toHtml() && str_contains($slot->toHtml(), '<a')) {
        $target = false;
    }
@endphp
<td
    {{ $attributes->merge([
            'x-on:click' => $target ? 'window.location = target' : null,
        ])->class([
            'cursor-pointer' => $target,
            'whitespace-nowrap px-4 py-2',
        ]) }}>
    {{ $slot }}
</td>
