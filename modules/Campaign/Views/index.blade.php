<x-app-layout>
    <x-slot name="header">
        <div class="flex">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Campaigns') }}
            </h2>

            <x-primary-button
                class="ml-auto"
                type="link"
            >
                <a href="{{ route('campaigns.create') }}">
                    {{ __('Create Campaign') }}
                </a>
            </x-primary-button>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @foreach ($campaigns as $campaign)
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <a
                            class="font-semibold text-2xl"
                            href="{{ route('campaigns.show', $campaign) }}"
                        > {{ $campaign->name }}</a>
                        <div>
                            {{ new \Funds\Core\Support\Amount($campaign->total_donated) }}
                            {{ $campaign->goal }}
                            <div class="inline-flex items-center">
                                <svg
                                    width="16"
                                    height="17"
                                    viewBox="0 0 16 17"
                                    fill="none"
                                    xmlns="http://www.w3.org/2000/svg"
                                >
                                    <path
                                        d="M8.00008 9.16667C9.84103 9.16667 11.3334 7.67428 11.3334 5.83333C11.3334 3.99238 9.84103 2.5 8.00008 2.5C6.15913 2.5 4.66675 3.99238 4.66675 5.83333C4.66675 7.67428 6.15913 9.16667 8.00008 9.16667Z"
                                        stroke="#111111"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                    />
                                    <path
                                        d="M13.3334 14.5001C13.3334 13.0856 12.7715 11.729 11.7713 10.7288C10.7711 9.72865 9.41457 9.16675 8.00008 9.16675C6.58559 9.16675 5.22904 9.72865 4.22885 10.7288C3.22865 11.729 2.66675 13.0856 2.66675 14.5001"
                                        stroke="#111111"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                    />
                                </svg>

                                {{ $campaign->donations_count }}
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
</x-app-layout>
