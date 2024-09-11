<x-campaign-layout :campaign="$campaign">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
        <div class="  overflow-hidden  sm:rounded-lg bg-gray-50">
            <div class="p-6 text-gray-900 ">
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

                <div class="mb-2 text-black">
                    <div class="inline-flex items-center">
                        <x-icons.calendar />
                        <span class="text-sm ml-4">
                            {{ $campaign->start_date?->isoFormat('L') }} -
                            {{ $campaign->end_date?->isoFormat('L') }}
                        </span>
                    </div>
                </div>
                <div class="mb-2 text-black">
                    <div class="inline-flex items-center">
                        <x-icons.percentage />
                        <span class="text-sm ml-4">
                            {{ $campaign->fees }}% {{ __('Fees') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-gray-50  overflow-hidden  sm:rounded-lg">
            <x-campaigns::donut-chart :$campaign />
            <div class="text-center my-4">
                <span class="text-lg">
                    {{ __('Total Donations') }}:
                    {{ $campaign->donations->count() }}
                </span>
            </div>
        </div>

        <div class="bg-gray-50  overflow-hidden  sm:rounded-lg">
            <div class="p-6 text-black text-sm">
                <span class="text-lg">
                    {{ __('Top Rewards') }}
                </span>
                <ul>
                    @foreach ($rewards as $reward)
                        <li class="flex justify-between py-4 border-b">
                            {{ $reward->name }} <span>{{ $reward->order_count }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="bg-gray-50  overflow-hidden  sm:rounded-lg">
            <div class="p-6 ">
                <span class="text-gray-500 text-sm">
                    Ø {{ __('Average Donation') }}
                </span>
                <p class="text-lg">
                    {{ $averageDonation }}</p>
                </p>
            </div>
        </div>
        <div class="bg-gray-50  overflow-hidden  sm:rounded-lg">
            <div class="p-6 ">
                <span class="text-gray-500 text-sm">
                    {{ __('Total Amount without Fees') }}
                </span>
                <p class="text-lg">
                    {{ $adjustedTotalAmount }}</p>
                </p>
            </div>
        </div>
    </div>
</x-campaign-layout>
