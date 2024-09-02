@props(['round' => false, 'outlined' => false])
@php
    $class = 'inline-flex items-center px-4 py-2
        focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2
        transition ease-in-out duration-150 ';
    $class .= $round ? ' rounded-full' : ' rounded-[20px] ';

    if ($outlined) {
        $class .=
            ' text-black border border-tangerine-400 hover:border-tangerine-500 focus:border-tangerine-500 active:border-tangerine-600 ';
    } else {
        $class .=
            ' bg-tangerine-400 text-white hover:bg-tangerine-500 hover:bg-tangerine-500 focus:bg-tangerine-500  active:bg-tangerine-600 ';
    }
@endphp

@if ($attributes->get('href'))
    <a {{ $attributes->class($class) }}>
        {{ $slot }}
    </a>
@else
    <button {{ $attributes->class($class)->merge(['type' => 'submit']) }}>
        {{ $slot }}
    </button>
@endif
