<x-app-layout :title="page_title(__('Create Campaign'))">
    <x-form-page-container :title="__('Create Campaign')">
        <form
            method="post"
            action="{{ route('campaigns.store') }}"
        >
            @csrf
            <div class="mb-4">
                <x-input
                    type="text"
                    name="name"
                    :label="__('Title')"
                    :placeholder="__('A new Campaign')"
                    :value="old('name')"
                    required
                />
            </div>
            <div class="grid grid-cols-2 gap-2 mb-4">
                <x-input-money
                    name="goal"
                    :label="__('Donation Goal')"
                    placeholder="1000,00"
                    :value="old('goal')"
                    required
                />
                <x-input
                    type="number"
                    name="fees"
                    :label="__('Transaction fees')"
                    placeholder="{{ __('Transaction fees') }} %"
                    {{-- required --}}
                />
            </div>
            <div class="grid grid-cols-2 gap-2 mb-4">
                <x-input-date-simple
                    name="start_date"
                    :label="__('Start Date')"
                    placeholder="{{ __('Start Date') }}"
                />
                <x-input-date-simple
                    name="end_date"
                    :label="__('End Date')"
                    placeholder="{{ __('End Date') }}"
                />
            </div>
            <x-button
                outlined
                wire:navigate
                :href="route('campaigns.index')"
            >
                {{ __('Cancel') }}
            </x-button>
            <x-button type="submit">
                {{ __('Create Campaign') }}
            </x-button>
        </form>
    </x-form-page-container>
</x-app-layout>
