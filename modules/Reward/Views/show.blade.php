{{-- @props(['campaign', 'actions' => null, 'backRoute' => null]) --}}
<x-app-layout>
    <x-slot name="header">
        <a
            class="mb-2 flex items-center text-xs text-gray-500"
            href="{{ route('rewards.index') }}"
        >
            <svg
                width="18"
                height="19"
                viewBox="0 0 18 19"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
            >
                <path
                    d="M9 14.75L3.75 9.5L9 4.25"
                    stroke="#6B7280"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                />
                <path
                    d="M14.25 9.5H3.75"
                    stroke="#6B7280"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                />
            </svg>
            {{ __('Back') }}
        </a>
        <div class="flex min-h-12 border-b py-2">
            <a
                class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight"
                href="{{ $campaign->appRoute() }}"
            >
                {{ $reward->name }}
            </a>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @isset($subnav)
                <div class="border-b py-2">
                    <x-campaigns::campaign-nav :campaign="$campaign" />
                </div>
            @endisset
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold">
                        {{ $reward->name }}
                    </h3>
                    <p class="text-3xl font-semibold">
                        {{ $reward->description }}
                    </p>
                    <p class="text-3xl font-semibold">
                        {{ $reward->min_amount }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
