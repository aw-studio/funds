<tr
    x-data="{ target: @js($attributes->get('href', null)) }"
    {{ $attributes->class(['p-4'])->except('href') }}
>
    {{ $slot }}
</tr>
