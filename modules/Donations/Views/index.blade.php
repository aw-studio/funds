<x-campaign-layout backRoute="{{ $campaign->appRoute() }}">
    <x-slot name="actions">
        <x-secondary-button
            class="ml-auto"
            href="{{ route('donations.create') }}"
        >
            {{ __('Add Donation') }}
        </x-secondary-button>
    </x-slot>

    <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200">
        {{ __('Metrics') }}
    </h2>
    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <h3 class="text-lg font-semibold">
                    {{ __('Total Donations') }}
                </h3>
                <p class="text-3xl font-semibold">
                    {{ $campaign->donations->count() }}
                </p>
            </div>
        </div>
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <h3 class="text-lg font-semibold">
                    {{ __('Total Amount') }}
                </h3>
                <p class="text-3xl font-semibold">
                    {{ new \Funds\Core\Support\Amount($campaign->donations->sum('amount.cents')) }}
                </p>
            </div>
        </div>
    </div>

    <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200">
        {{ __('Donations') }}
    </h2>
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <livewire:donations-listing :donations="$donations" />
            </div>
        </div>
    </div>

</x-campaign-layout>
