@props(['target' => true])
@php
    if ($slot->toHtml() && str_contains($slot->toHtml(), '<a')) {
        $target = false;
    }
@endphp
<td
    @if ($target) x-bind:class="{
        'cursor-pointer': target
    }" @endif
    {{ $attributes->merge([
            'x-on:click' => $target ? 'Livewire.navigate(target)' : null,
        ])->class(['whitespace-nowrap px-4 py-2']) }}
>
    {{ $slot }}
</td>
