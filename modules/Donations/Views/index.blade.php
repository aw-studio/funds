<x-campaign-layout backRoute="{{ $campaign->appRoute() }}">
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

    @if ($pendingDonationsCount > 0)
        <a
            class="p-4 text-center block"
            href="{{ route('donations.intents.index') }}"
        >
            {{ __('Pending Donations') }}: {{ $pendingDonationsCount }}
        </a>
    @endif
</x-campaign-layout>
