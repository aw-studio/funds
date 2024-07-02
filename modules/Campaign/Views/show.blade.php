<x-campaign-layout :campaign="$campaign">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <span class="bg-gray-200 text-xs p-1 rounded-md">{{ $campaign->status }}</span>
                <h2 class="text-2xl font-semibold">{{ $campaign->name }}</h2>
            </div>
        </div>
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <h3 class="text-lg font-semibold">
                    {{ $campaign->totalAmountDonated() }}
                    /
                    {{ $campaign->goal }}</h3>
            </div>
        </div>

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
    </div>
</x-campaign-layout>
