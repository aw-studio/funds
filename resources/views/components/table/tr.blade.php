<tr
    @if ($attributes->get('href')) x-data="{ target: @js($attributes->get('href', '')) }" @endif
    {{ $attributes->class(['p-4']) }}
>
    {{ $slot }}
</tr>
