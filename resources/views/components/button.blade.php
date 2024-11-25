@props([
    'round' => false,
    'outlined' => false,
    'iconButton' => false,
    'variant' => 'default',
])

@php
    $baseClasses = [
        'inline-flex items-center',
        'focus-visible:outline-none focus-visible:ring-2 focus:ring-offset-2',
        'transition ease-in-out duration-150',
    ];

    $shapeClasses = $round ? ['rounded-full'] : ['rounded-[20px]', 'px-4 py-2'];

    $stateClasses = $attributes->get('disabled') ? ['cursor-not-allowed', 'opacity-50'] : ['active:ring-0'];

    $variantClasses = match (true) {
        $variant === 'danger' && $outlined => [
            'text-danger-500 border border-danger-500',
            'hover:border-danger-600 focus-visible:border-danger-600 active:border-danger-700',
        ],
        $variant === 'danger' => [
            'bg-danger-500 text-white',
            'hover:bg-danger-600 focus:bg-danger-600 active:bg-danger-700',
        ],
        $outlined => [
            'text-black border border-orange-400',
            'hover:border-orange-500 focus-visible:border-orange-500 active:border-orange-600',
        ],
        default => ['bg-orange-400 text-white', 'hover:bg-orange-500 focus:bg-orange-500 active:bg-orange-600'],
    };

    $iconButtonClasses = $iconButton ? ['!p-0 justify-center', 'rounded-full'] : [];

    $classes = implode(
        ' ',
        array_unique(array_merge($baseClasses, $shapeClasses, $stateClasses, $variantClasses, $iconButtonClasses)),
    );
@endphp

@if ($attributes->get('href'))
    <a {{ $attributes->class($classes) }}>
        {{ $slot }}
    </a>
@else
    <button {{ $attributes->class($classes)->merge(['type' => 'submit']) }}>
        {{ $slot }}
    </button>
@endif
