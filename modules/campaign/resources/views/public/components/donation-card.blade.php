@php
    $href = $attributes->get('disabled') ? null : $attributes->get('href');
@endphp
<a
    @if ($href) href="{{ $href }}" @endif
    {{ $attributes->class([
            'mb-8 p-4 card block',
            'cursor-not-allowed opacity-50' => $attributes->get('disabled'),
            'cursor-pointer' => $href,
        ])->except('href') }}
>
    {{ $slot }}
</a>
