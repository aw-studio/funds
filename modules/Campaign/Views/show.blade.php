<x-campaign-layout :campaign="$campaign">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
        <div class=" dark:bg-gray-800 overflow-hidden  sm:rounded-lg bg-gray-50">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <div class="mb-4">
                    <span class="bg-gray-200 text-xs p-1 rounded-md">{{ $campaign->status }}</span>
                </div>
                {{ __('Campaign') }}
                <p class="text-xl">{{ $campaign->name }}</p>

                <hr class="my-10">
                <h3 class="text-lg mb-4">
                    {{ $campaign->totalAmountDonated() }}
                    /
                    {{ $campaign->goal }}</h3>
                <div>
                    <div class="bg-gray-200 w-full h-3 rounded-full">
                        <div
                            class="bg-amethyst-500 h-3 rounded-full"
                            style="width: {{ $campaign->progress() }}%;"
                        ></div>
                    </div>
                </div>

                <hr class="my-10" />

                <h3 class="text-lg mb-4">
                    <div>
                        <div class="inline-flex items-center">
                            <x-icons.calendar />
                            <span class="text-sm ml-4">
                                {{ $campaign->start_date?->isoFormat('L') }} -
                                {{ $campaign->end_date?->isoFormat('L') }}
                            </span>
                        </div>
                    </div>
            </div>
        </div>
        <div class="bg-gray-50 dark:bg-gray-800 overflow-hidden  sm:rounded-lg">
            <x-campaigns::donut-chart :$campaign />
            <div class="text-center my-4">
                <span class="text-lg">
                    {{ __('Total Donations') }}:
                    {{ $campaign->donations->count() }}
                </span>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 overflow-hidden  sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">

            </div>
        </div>
    </div>
</x-campaign-layout>
