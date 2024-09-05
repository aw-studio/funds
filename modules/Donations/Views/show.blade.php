<x-app-layout :backRoute="route('donations.index')">
    <div class="mx-auto max-w-7xl py-12">

        <h2 class="text-2xl font-serif text-gray-800">
            @lang('Donation') #{{ $donation->id }}
        </h2>
        <hr />
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
            <div>
                {{ __('Transaction') }}
                <div class="text-xl font-bold font-serif mb-2">
                    {{ $donation->amount }}
                </div>
                <hr />
                <div class="flex gap-2">
                    <x-icons.calendar />

                    {{ $donation->created_at->isoFormat('L LT') }}
                </div>
                <div class="flex gap-2">
                    <x-icons.rotate />
                    {{ $donation->type->label() }}
                </div>
                <div class="flex gap-2">
                    @if ($donation->paidFees())
                        <x-icons.square-percent />
                        <span>{{ $donation->paidFeeAmount() }} ({{ $donation->campaign->fees }}%)
                            {{ __('Transaction fees paid') }}</span>
                    @endif
                </div>

            </div>
            <div class="flex flex-col gap-8">
                <div>
                    <span>{{ __('Donor') }}</span>
                    <div class="text-xl">
                        <p>{{ $donation->donor->name }}</p>
                        <span class="text-sm"> {{ $donation->donor->email }}</span>
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
                        {{-- {{ $donation->order->status }} --}}
                        {{ __('Shipment address') }}
                        <div>
                            {{ $donation->order->shipping_address['name'] }}<br />
                            {{ $donation->order->shipping_address['address'] }} <br />
                            {{ $donation->order->shipping_address['address_addition'] }}
                            {{ $donation->order->shipping_address['postal_code'] }}
                            {{ $donation->order->shipping_address['city'] }} <br />
                            {{ $donation->order->shipping_address['country'] }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
</x-app-layout>
