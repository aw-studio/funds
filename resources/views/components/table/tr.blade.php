<tr
    x-data="{ target: @js($attributes->get('href', '')) }"
    {{ $attributes->class(['p-4']) }}
>
    {{ $slot }}
</tr>
