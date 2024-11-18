@props(['title'])
<div {{ $attributes->class(['bg-gray-50 p-4 rounded-lg']) }}>
    @if (isset($title))
        <div class="flex border-b mb-2 pb-2">
            <span class="font-serif font-semibold text-xl ">
                {{ $title }}
            </span>
        </div>
    @endif
    {{ $slot }}
</div>
