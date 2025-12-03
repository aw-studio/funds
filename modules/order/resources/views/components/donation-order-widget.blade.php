@if ($donation->order)
    @pushOnce('widgets')
        <x-card>
            <div class="flex justify-between">
                <p class="font-serif text-xl">{{ __('Order') }}</p>
                <livewire:toggle-order-on-hold :order="$donation->order" />
            </div>
            <div class="border-t border-gray-200 mt-4 pt-4 flex justify-between">
                <div>
                    <span class="text-gray-500 text-sm">{{ __('Selected Reward') }}</span>
                    <div class="text-lg font-serif">
                        {{ $donation->order->reward->name }}

                    </div>
                    <div class="mt-2">
                        @if ($donation->order->rewardVariant)
                            <p class="flex gap-2 items-center">
                                <x-icons.tag />
                                {{ $donation->order->rewardVariant->name }}
                            </p>
                        @endif
                    </div>
                    <div class="mt-4">
                        <span class="text-sm text-gray-500">{{ __('Note') }}</span>
                        <div class="flex gap-2">
                            {{ $donation->order->note }}
                        </div>
                    </div>
                </div>
                <x-button
                    outlined
                    round
                    :href="route('orders.edit', $donation->order)"
                    wire:navigate
                    class="w-10 h-10"
                    iconButton
                >
                    <x-icons.pencil />
                </x-button>
            </div>
            <div class="border-t border-gray-200 mt-4 pt-4">
                <span class="text-sm text-gray-500">{{ __('Shipment address') }}</span>
                <div class="flex justify-between">
                    <div>
                        {{ $donation->order->shipping_address['name'] }}<br />
                        {{ $donation->order->shipping_address['street'] }} <br />
                        {{ $donation->order->shipping_address['address_addition'] ?? '' }}
                        {{ $donation->order->shipping_address['postal_code'] }}
                        {{ $donation->order->shipping_address['city'] }} <br />
                        {{ $donation->order->shipping_address['country'] }}
                    </div>
                    <x-button
                        outlined
                        round
                        :href="route('orders.shipping-address.edit', $donation->order)"
                        wire:navigate
                        class="w-10 h-10"
                        iconButton
                    >
                        <x-icons.pencil />
                    </x-button>
                </div>
            </div>

        </x-card>
    @endpushOnce
@else
    @pushOnce('widgets')
        <x-card>
            <div class="flex justify-between">
                <p class="font-serif
            text-xl">{{ __('Order') }}</p>
            </div>
            <div class="border-t border-gray-200 mt-4 pt-4">
                <x-button
                    outlined
                    :href="route('orders.create', ['donation' => $donation])"
                    wire:navigate
                >
                    {{ __('Add Order') }}
                </x-button>
            </div>
        </x-card>
    @endpushOnce
@endif
