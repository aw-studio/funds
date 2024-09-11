<x-app-layout :backLink="route('donations.index')">
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-serif">
            @lang('Donation') #{{ $donation->id }}
        </h2>
        <hr class="mt-4 mb-8" />
        <div class="grid grid-cols-1 gap-8 md:grid-cols-2">
            <div>
                <div class="">
                    {{ __('Transaction') }}
                    <div class="text-xl font-bold font-serif mb-2">
                        {{ $donation->amount }}
                    </div>
                </div>
                <hr class="my-8" />
                <div class="space-y-2">
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
                <hr class="my-8" />
                @if ($donation->receipt_address)
                    <dic class="">
                        <span>{{ __('Receipt address') }}</span>
                        <div>
                            {{ $donation->receipt_address['name'] }}<br />
                            {{ $donation->receipt_address['address'] }} <br />
                            {{ $donation->receipt_address['postal_code'] }}
                            {{ $donation->receipt_address['city'] }} <br />
                            {{ $donation->receipt_address['country'] }}
                        </div>
                        {{-- TODO: Add download receipt button --}}
                    </dic>
                @endif

            </div>
            <div class="flex flex-col gap-8">
                <div>
                    <span class="text-gray-500 text-sm">{{ __('Donor') }}</span>
                    <div>
                        <p class="text-xl font-serif">{{ $donation->donor->name }}</p>
                        <p class="flex gap-2 mt-2 items-center">
                            <x-icons.mail />
                            {{ $donation->donor->email }}
                        </p>
                    </div>
                </div>
                <div>
                    <span class="text-gray-500 text-sm">{{ __('Type') }}</span>
                    <div class="text-xl font-serif">
                        {{ $donation->label() }}
                    </div>
                    <div class="mt-2">
                        @if ($donation->reward)
                            <p class="flex gap-2 items-center">
                                <x-icons.gift />
                                {{ $donation->reward->name }}
                            </p>
                        @endif
                        @if ($donation->rewardVariant)
                            <p class="flex gap-2 items-center">
                                <x-icons.tag />
                                {{ $donation->rewardVariant->name }}
                            </p>
                        @endif
                    </div>
                </div>

                @if ($donation->order)
                    <div class="">
                        <span class="text-sm text-gray-500">{{ __('Shipment address') }}</span>
                        <div>
                            {{ $donation->order->shipping_address['name'] }}<br />
                            {{ $donation->order->shipping_address['street'] }} <br />
                            {{ $donation->order->shipping_address['address_addition'] ?? '' }}
                            {{ $donation->order->shipping_address['postal_code'] }}
                            {{ $donation->order->shipping_address['city'] }} <br />
                            {{ $donation->order->shipping_address['country'] }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
</x-app-layout>
