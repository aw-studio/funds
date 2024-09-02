<x-app-layout>
    <x-slot name="header">
        <div class="flex">
            <h2 class="font-bold font-serif text-2xl text-gray-800 dark:text-gray-200 leading-tight font-rubik">
                {{ __('Campaigns') }}
            </h2>

            <x-button
                class="ml-auto"
                href="{{ route('campaigns.create') }}"
            >
                {{ __('Create Campaign') }}
            </x-button>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @foreach ($campaigns as $campaign)
                <div class="overflow-hidden shadow-sm sm:rounded-lg bg-gray-50">
                    <div class="p-6 text-gray-900 ">
                        <a
                            class="font-serif text-xl font-semibold"
                            href="{{ route('campaigns.show', $campaign) }}"
                        > {{ $campaign->name }}</a>
                        <div>
                            {{ new \Funds\Core\Support\Amount($campaign->total_donated ?? 0) }}
                            {{ $campaign->goal }}
                            <div class="inline-flex items-center">
                                <x-icons.user-round />
                                {{ $campaign->donations_count }}
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
</x-app-layout>
