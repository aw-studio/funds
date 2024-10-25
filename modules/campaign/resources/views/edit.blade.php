<x-app-layout>
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="flex min-h-12 border-b py-2">
                <span class="font-serif font-bold text-2xl text-gray-800  leading-tight">
                    {{ __('Edit Campaign') }}
                </span>
            </div>

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
                    <x-money-input
                        name="goal"
                        :value="$campaign->goal->get()"
                        :label="__('Donation Goal')"
                    />
                    <x-input
                        type="number"
                        name="fees"
                        :label="__('Fees')"
                        :placeholder="__('Fees')"
                        :value="$campaign->fees"
                    />
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
                >
                    {{ __('Cancel') }}
                </x-button>
                <x-button type="submit">
                    {{ __('Update Campaign') }}
                </x-button>
            </form>
        </div>
    </div>
</x-app-layout>
