        <div class="  overflow-hidden  sm:rounded-lg bg-gray-50">
            <div class="p-6 text-gray-900 ">
                <div class="mb-4">
                    <x-campaigns::status-badge :campaign="$campaign" />
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
