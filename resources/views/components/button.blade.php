@props(['round' => false, 'outlined' => false])
@php
    $class = 'inline-flex items-center px-4 py-2
        focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 focus:ring-offset-2
        active:ring-0
        transition ease-in-out duration-150 ';
    $class .= $round ? ' rounded-full' : ' rounded-[20px] ';

    if ($outlined) {
        $class .=
            ' text-black border border-orange-400 hover:border-orange-500 focus-visible:border-orange-500 active:border-orange-600 ';
    } else {
        $class .=
            ' bg-orange-400 text-white hover:bg-orange-500 hover:bg-orange-500 focus:bg-orange-500  active:bg-orange-600 ';
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
