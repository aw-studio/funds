<x-campaign-layout backRoute="{{ $campaign->appRoute() }}">
    <x-slot name="actions">
        <x-dropdown align="right">
            <x-slot name="trigger">
                <button
                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150"
                >
                    <div class="rounded-full h-10 w-10 bg-white flex items-center justify-center">
                        <svg
                            width="20"
                            height="20"
                            viewBox="0 0 20 20"
                            fill="none"
                            xmlns="http://www.w3.org/2000/svg"
                            class="stroke-current text-gray-500 dark:text-gray-400"
                        >
                            <path
                                d="M10.0001 10.8332C10.4603 10.8332 10.8334 10.4601 10.8334 9.99984C10.8334 9.5396 10.4603 9.1665 10.0001 9.1665C9.53984 9.1665 9.16675 9.5396 9.16675 9.99984C9.16675 10.4601 9.53984 10.8332 10.0001 10.8332Z"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            />
                            <path
                                d="M15.8333 10.8332C16.2936 10.8332 16.6667 10.4601 16.6667 9.99984C16.6667 9.5396 16.2936 9.1665 15.8333 9.1665C15.3731 9.1665 15 9.5396 15 9.99984C15 10.4601 15.3731 10.8332 15.8333 10.8332Z"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            />
                            <path
                                d="M4.16659 10.8332C4.62682 10.8332 4.99992 10.4601 4.99992 9.99984C4.99992 9.5396 4.62682 9.1665 4.16659 9.1665C3.70635 9.1665 3.33325 9.5396 3.33325 9.99984C3.33325 10.4601 3.70635 10.8332 4.16659 10.8332Z"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            />
                        </svg>
                    </div>

                    <div class="ms-1">

                    </div>
                </button>
            </x-slot>

            <x-slot name="content">
                <x-dropdown-link
                    :href="route('donations.create')"
                    wire:navigate
                >
                    {{ __('Add Donation') }}
                </x-dropdown-link>
                <x-dropdown-link
                    :href="$campaign->publicRoute()"
                    wire:navigate
                >
                    {{ __('View Campaign') }}
                </x-dropdown-link>

            </x-slot>
        </x-dropdown>
    </x-slot>

    <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200">
        {{ __('Donation Intents') }}
    </h2>
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                @foreach ($intents as $intent)
                    <div
                        class="flex items-center justify-between mb-4 border-b border-gray-200 dark:border-gray-700 py-2">
                        <div class="">
                            {{ new \Funds\Core\Support\Amount($intent->amount) }}
                        </div>
                        <div class="">
                            {{ $intent->email }}
                        </div>
                        <div class="">
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                {{ $intent->status }}
                            </p>
                        </div>
                        <div class="ml-4">

                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                {{ $intent->created_at->diffForHumans() }}
                            </p>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>

</x-campaign-layout>
