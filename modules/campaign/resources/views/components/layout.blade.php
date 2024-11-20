@props(['campaign', 'backRoute' => null])
<x-app-layout
    :backLink="$backRoute ?? route('campaigns.index')"
    :title="page_title($campaign->name, __('Campaigns'))"
>
    <x-slot name="header">
        <div class="flex">
            <a
                class="font-bold text-2xl font-serif text-gray-800 leading-tight"
                href="{{ $campaign->appRoute() }}"
                wire:navigate
            >
                {{ $campaign->name }}
            </a>

            <div class="ml-auto flex items-center gap-4">
                <livewire:publish-campaign :campaign="$campaign" />
                <x-dropdown align="right">
                    <x-slot name="trigger">
                        <x-button
                            round
                            class="w-10 h-10 !p-0 items-center justify-center"
                        >
                            <x-icons.dots class="text-white" />
                        </x-button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link
                            :href="route('campaigns.edit', ['campaign' => $campaign])"
                            wire:navigate
                        >
                            {{ __('Edit Campaign') }}
                        </x-dropdown-link>
                        <x-dropdown-link
                            :href="route('donations.create')"
                            wire:navigate
                        >
                            {{ __('Add Donation') }}
                        </x-dropdown-link>
                        <x-dropdown-link
                            :href="$campaign->publicRoute()"
                            wire:navigate
                            target="_blank"
                        >
                            {{ __('View Campaign') }}
                        </x-dropdown-link>

                    </x-slot>
                </x-dropdown>
            </div>
        </div>
    </x-slot>
    <div class="">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div>
                <x-campaign::campaign-nav :campaign="$campaign" />
            </div>
            {{ $slot }}
        </div>
    </div>
</x-app-layout>
