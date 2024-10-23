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
                    <x-campaigns::progress-bar
                        color="bg-amethyst-500"
                        progress="{{ $campaign->progress() }}"
                    />
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
