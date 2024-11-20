@props(['reward', 'countries' => []])
@if ($reward !== null)
    <div class="shipmentDetails">
        <p class="checkout-section-header text-2xl">{{ __('Shipping') }}</p>
        <div class="grid grid-cols-2 gap-2 mb-5">
            <x-input
                name="shipping_name"
                type="text"
                placeholder="Jane Doe"
                value="{{ old('shipping_name') }}"
                autocomplete="name"
                label="{{ __('Full name') }}"
                required
                class="mb-2"
            />
            <x-input
                name="street"
                autocomplete="street-address"
                placeholder="{{ __('Street address') }}"
                label="{{ __('Street address') }}"
                value="{{ old('street') }}"
                maxlength="300"
                required
                class="mb-2"
            />
            <x-input
                name="address_addition"
                type="text"
                placeholder="{{ __('Address addition') }}"
                label="{{ __('Address addition') }}"
                value="{{ old('address_addition') }}"
                class="mb-2"
            />
            <x-input
                name="postal_code"
                type="text"
                autocomplete="postal-code"
                placeholder="{{ __('Postal code') }}"
                label="{{ __('Postal code') }}"
                value="{{ old('postal_code') }}"
                required
                class="mb-2"
            />
            <x-input
                name="city"
                type="text"
                autocomplete="address-level2"
                placeholder="{{ __('City') }}"
                label="{{ __('City') }}"
                value="{{ old('city') }}"
                required
                class="mb-2"
            />

            <div class="mb-2">
                <x-country-select selectedOption="{{ old('country') }}" />
            </div>

        </div>
    </div>
@endif
