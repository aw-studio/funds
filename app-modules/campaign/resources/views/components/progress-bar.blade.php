@props([
    'progress' => 0,
    'color' => 'bg-orange-500',
    'bgColor' => 'bg-gray-200',
])

<div {{ $attributes->class(['w-full h-3 rounded-full mt-4 bg-gray-200']) }}>
    <div
        @class(["h-3 rounded-l $color", 'rounded-full' => $progress > 99])
        style="width: 0%; transition: width 1s ease;"
        x-data
        x-init="$nextTick(() => $el.style.width = '{{ $progress }}%')"
    ></div>
</div>
