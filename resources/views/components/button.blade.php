@props(['round' => false, 'outlined' => false, 'iconButton' => false])
@php
    $classes = [
        'inline-flex items-center',
        'focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 focus:ring-offset-2',
        'active:ring-0',
        'transition ease-in-out duration-150',
    ];
    $classes[] = 'px-4 py-2';

    if ($round) {
        $classes[] = 'rounded-full';
    } else {
        $classes[] = 'rounded-[20px]';
    }

    if ($outlined) {
        $classes[] = 'text-black border border-orange-400';
        $classes[] = 'hover:border-orange-500 focus-visible:border-orange-500 active:border-orange-600';
    } else {
        $classes[] = 'bg-orange-400 text-white';
        $classes[] = 'hover:bg-orange-500 hover:bg-orange-500 focus:bg-orange-500 active:bg-orange-600';
    }

    if ($iconButton) {
        $classes[] = '!p-0 justify-center';
        $classes[] = 'rounded-full';
    }

    $class = implode(' ', array_unique($classes));
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
