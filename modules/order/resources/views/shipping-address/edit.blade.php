<x-app-layout :backRoute="route('donations.show', $order->donation_id)">
    <x-form-page-container title="Edit Shipping Address">
        <form
            action="{{ route('orders.shipping-address.update', $order) }}"
            method="POST"
            class="space-y-4"
        >
            @csrf
            @method('PUT')
            <x-input
                label="Name"
                name="name"
                value="{{ $order->shipping_address['name'] }}"
                required
            />
            <x-input
                label="Street Address"
                name="street"
                value="{{ $order->shipping_address['street'] }}"
                required
            />
            <x-input
                label="Address addition"
                name="address_addition"
                value="{{ $order->shipping_address['address_addition'] ?? '' }}"
            />
            <div class="grid grid-cols-2 gap-2">
                <x-input
                    label="Postal Code"
                    name="postal_code"
                    value="{{ $order->shipping_address['postal_code'] }}"
                    required
                />
                <x-input
                    label="City"
                    name="city"
                    value="{{ $order->shipping_address['city'] }}"
                    required
                />
            </div>
            <x-input
                label="Country"
                name="country"
                value="{{ $order->shipping_address['country'] }}"
                required
            />
            <x-country-select
                label="Country"
                name="country"
                value="{{ $order->shipping_address['country'] }}"
                required
            />
            <div class="my-10">
                <x-button
                    outlined
                    :href="route('donations.show', $order->donation_id)"
                >
                    {{ __('Cancel') }}
                </x-button>
                <x-button type="submit">
                    {{ __('Save') }}
                </x-button>
            </div>

        </form>
    </x-form-page-container>
</x-app-layout>
