@props([
    'progress' => 0,
    'color' => 'bg-tangerine-500',
])
<div class="bg-gray-200 w-full h-3 rounded-full mt-4">
    <div
        class="h-3 rounded-full {{ $color }}"
        style="width: {{ $progress }}%;"
    ></div>
</div>
