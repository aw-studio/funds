<x-app-layout :title="page_title(__('Campaigns'))">
    <x-slot name="header">
        <div class="flex mt-12">
            <x-page-headline :value="__('Campaigns')" />
            <x-button
                class="ml-auto"
                :href="route('campaigns.create')"
                wire:navigate
            >
                {{ __('Create Campaign') }}
            </x-button>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @foreach ($campaigns as $campaign)
                <div class="overflow-hidden sm:rounded-lg bg-gray-50">
                    <div class="p-6 text-gray-900 ">
                        <x-campaign::status-badges :campaign="$campaign" />
                        <div class="mt-4">
                            <a
                                href="{{ route('campaigns.show', $campaign) }}"
                                wire:navigate
                            >
                                <x-section-headline :value="$campaign->name" />

                            </a>

                        </div>
                        <div class="text-sm text-gray-500 mt-1">
                            {{ $campaign->start_date->isoFormat('L') }} - {{ $campaign->end_date->isoFormat('L') }}
                        </div>
                        <x-campaign::progress-bar :progress="$campaign->progress()" />
                        <div class="mt-4 flex gap-4">
                            <div class="inline-flex">
                                <x-icons.money />
                                <span class="text-sm">
                                    {{ $campaign->totalAmountDonated() }} /
                                    {{ $campaign->goal }}</span>
                            </div>
                            <div class="inline-flex ">
                                <x-icons.user-round />
                                <span class="text-sm ">{{ $campaign->donations_count }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
</x-app-layout>
