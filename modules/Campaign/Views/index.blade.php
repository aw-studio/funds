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
                        {{ $campaign->created_at->isoFormat('L') }}
                        {{ $campaign->updated_at->isoFormat('L') }}
                    </div>
                </div>
            @endforeach
        </div>
</x-app-layout>
