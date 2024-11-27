@php
    $href = $attributes->get('disabled') ? null : $attributes->get('href');
@endphp
<a
    @if ($href) href="{{ $href }}" @endif
    {{ $attributes->class([
            'p-5 card block',
            'cursor-not-allowed opacity-50' => $attributes->get('disabled'),
            'cursor-pointer' => $href,
        ])->except('href') }}
>
    {{ $slot }}
</a>
