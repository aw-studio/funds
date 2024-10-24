<x-app-layout>
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="flex min-h-12 border-b py-2">
                <span class="font-serif font-bold text-2xl text-gray-800  leading-tight">
                    {{ __('Create Campaign') }}
                </span>
            </div>

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
                    <x-money-input
                        name="goal"
                        :label="__('Donation Goal')"
                        placeholder="1000,00"
                        :value="old('goal')"
                        required
                    />
                    <x-input
                        type="number"
                        name="fees"
                        :label="__('Fees')"
                        placeholder="{{ __('Fees') }} %"
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
                    :href="route('campaigns.index')"
                >
                    {{ __('Cancel') }}
                </x-button>
                <x-button type="submit">
                    {{ __('Create Campaign') }}
                </x-button>
            </form>
        </div>
    </div>
</x-app-layout>
