@if (isset($href))
    <a
        {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center px-4 py-2 bg-white  border border-gray-300  rounded-md font-semibold text-xs text-gray-700  tracking-wider shadow-sm hover:bg-gray-50 :bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 :ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150']) }}>
        {{ $slot }}
    </a>
@else
    <button
        {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center px-4 py-2 bg-white  border border-gray-300  rounded-md font-semibold text-xs text-gray-700  tracking-wider shadow-sm hover:bg-gray-50 :bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 :ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150']) }}
    >
        {{ $slot }}
    </button>
@endif
