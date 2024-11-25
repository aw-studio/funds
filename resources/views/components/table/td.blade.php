@props(['target' => true])
@php
    if ($slot->toHtml() && str_contains($slot->toHtml(), '<a')) {
        $target = false;
    }
@endphp
<td
    {{ $attributes->merge([
            'x-on:click' => $target ? 'target && Livewire.navigate(target)' : null,
            'x-bind:class' => $target ? 'target && "cursor-pointer"' : null,
        ])->class(['whitespace-nowrap px-4 py-2']) }}>
    {{ $slot }}
</td>
