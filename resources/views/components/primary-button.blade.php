@props(['round' => false])
@php
    $class = 'inline-flex items-center px-4 py-2 bg-tangerine-400 border
        border-transparent font-semibold text-xs text-white
        hover:bg-tangerine-500 focus:bg-tangerine-500  active:bg-tangerine-600
        focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2
        transition ease-in-out duration-150';
    $class .= $round ? ' rounded-full' : ' rounded-2xl';
@endphp

@if (isset($href))
    <a {{ $attributes->class($class) }}>
        {{ $slot }}
    </a>
@else
    <button {{ $attributes->class($class)->merge(['type' => 'submit']) }}>
        {{ $slot }}
    </button>
@endif
