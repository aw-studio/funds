<x-app-layout :title="page_title(__('Edit Campaign'), $campaign->name)">
    <x-form-page-container :title="__('Edit Campaign')">
        <form
            method="post"
            action="{{ route('campaigns.update', $campaign) }}"
        >
            @csrf
            @method('put')
            <div class="mb-4">
                <x-input
                    type="text"
                    name="name"
                    placeholder="Name"
                    :label="__('Title')"
                    :value="$campaign->name"
                    required
                />

            </div>
            <div class="grid grid-cols-2 gap-2 mb-4">
                <x-input-money
                    name="goal"
                    :value="$campaign->goal->get()"
                    :label="__('Donation Goal')"
                />
                <x-input
                    type="number"
                    name="fees"
                    :label="__('Transaction fees')"
                    :placeholder="__('Transaction fees')"
                    :value="$campaign->fees"
                >
                    <x-slot name="prefix">
                        %
                    </x-slot>
                </x-input>
            </div>
            <div class="grid grid-cols-2 gap-2 mb-4">
                <x-input-date-simple
                    name="start_date"
                    :label="__('Start Date')"
                    :value="$campaign->start_date->format('Y-m-d')"
                />
                <x-input-date-simple
                    name="end_date"
                    :label="__('End Date')"
                    :value="$campaign->end_date->format('Y-m-d')"
                />
            </div>
            <x-button
                outlined
                :href="route('campaigns.show', $campaign)"
                wire:navigate
            >
                {{ __('Cancel') }}
            </x-button>
            <x-button type="submit">
                {{ __('Update Campaign') }}
            </x-button>
        </form>
    </x-form-page-container>
</x-app-layout>
