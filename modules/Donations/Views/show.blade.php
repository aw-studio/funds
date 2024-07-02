<x-campaign-layout :backRoute="route('donations.index')">
    <h2 class="text-2xl font-semibold text-gray-800">
        @lang('Donation') #{{ $donation->id }}
    </h2>
    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
        <div class="bg-white  overflow-hidden shadow-sm sm:rounded-lg p-6">
            <div class="text-xl font-semibold mb-2">
                {{ $donation->amount }}
            </div>
            {{ $donation->created_at->isoFormat('L LT') }}
            <div>
                {{ $donation->type === 'recurring' ? __('Recurring') : __('Onetime') }}
            </div>
            <div>
                {{ __('Pays fees') }}: {{ $donation->donationIntent->pays_fees ? 'yes' : 'no' }}
            </div>

        </div>
        <div class="flex flex-col gap-8">
            <div>
                <span>{{ __('Donor') }}</span>
                <div class="text-xl">
                    {{ $donation->donor->email }}
                </div>
            </div>
            <div>
                <span>{{ __('Type') }}</span>
                <div class="text-xl">
                    {{ $donation->label() }}
                </div>
                <div class="">
                    {{ $donation->reward?->name }}
                    @if ($donation->rewardVariant)
                        {{ $donation->rewardVariant->name }}
                    @endif
                </div>
            </div>

            @if ($donation->order)
                <div class="">
                    {{ $donation->order->status }}
                    {{ __('Shippment address') }}
                    <div>
                        {{ $donation->order->shipping_address['name'] }}
                    </div>
                </div>
            @endif
        </div>

</x-campaign-layout>
