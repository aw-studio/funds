@if ($donation->order)
    @push('widgets')
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
    @endpush
@endif
