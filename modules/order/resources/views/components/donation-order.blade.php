@if ($donation->order)
    @pushOnce('widgets')
        <x-card-widget>
            <div class="flex justify-between">
                <p class="font-serif text-xl">{{ __('Shipment') }}</p>
                <p>{{ $donation->order->shipment_status }}</p>
            </div>
            <span class="text-sm text-gray-500">{{ __('Shipment address') }}</span>
            <div>
                {{ $donation->order->shipping_address['name'] }}<br />
                {{ $donation->order->shipping_address['street'] }} <br />
                {{ $donation->order->shipping_address['address_addition'] ?? '' }}
                {{ $donation->order->shipping_address['postal_code'] }}
                {{ $donation->order->shipping_address['city'] }} <br />
                {{ $donation->order->shipping_address['country'] }}
            </div>

        </x-card-widget>
    @endpushOnce
@endif
