@props(['active'])
<a
    {{ $attributes }}
    @class([
        'inline-flex items-center px-1 pt-1 border-b-2 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out',
        'border-transparent' => !$active,
        '!border-amethyst-500 border-b-3' => $active,
    ])
>
    {{ $slot }}
</a>
