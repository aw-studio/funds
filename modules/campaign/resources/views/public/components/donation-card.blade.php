@php
    $href = $attributes->get('href');
@endphp
<a
    class="mb-8 p-4 card block"
    href="{{ $href }}"
>
    {{ $slot }}
</a>
