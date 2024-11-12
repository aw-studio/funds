@props([
    'progress' => 0,
    'color' => 'bg-orange-500',
    'bgColor' => 'bg-gray-200',
])

@php
    if ($progress < 25) {
        $duration = 250;
    } elseif ($progress < 50) {
        $duration = 500;
    } else {
        $duration = 1000;
    }
@endphp

<div {{ $attributes->class(['w-full h-3 rounded-full mt-4 bg-gray-200']) }}>
    <div
        @class([
            "h-3 $color",
            'rounded-l' => $progress < 99,
            'rounded-full' => $progress > 99,
        ])
        style="width: 0%; transition: width {{ $duration }}ms ease;"
        x-data
        x-init="$nextTick(() => $el.style.width = '{{ $progress }}%')"
    ></div>
</div>
