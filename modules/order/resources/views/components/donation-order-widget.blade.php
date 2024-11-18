@if ($donation->order)
    @pushOnce('widgets')
        <x-card>
            <div class="flex justify-between">
                <p class="font-serif text-xl">{{ __('Shipment') }}</p>
                <x-order::order-shipment-status-badge :order="$donation->order" />
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
                        href="{{ route('orders.shipping-address.edit', $donation->order) }}"
                        class="w-10 h-10"
                        iconButton
                    >
                        <x-icons.pencil />
                    </x-button>
                </div>
            </div>

        </x-card>
    @endpushOnce
@endif
