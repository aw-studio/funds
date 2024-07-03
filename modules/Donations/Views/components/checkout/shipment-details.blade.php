@props(['reward'])
@if ($reward !== null)
    <div>
        <h2 class="text-2xl font-semibold">{{ __('Shipping') }}</h2>
        <div class="grid grid-cols-2 gap-2 mb-5">
            <x-input
                name="shipping_name"
                type="text"
                placeholder="{{ __('Name') }}"
                value="{{ old('shipping_name') }}"
                autocomplete="name"
                required
            />
            <x-input
                name="address_addition"
                type="text"
                placeholder="{{ __('Address Addition') }}"
                value="{{ old('address_addition') }}"
            />
            <x-input
                name="address"
                autocomplete="address-line1"
                placeholder="{{ __('Street Address') }}"
                value="{{ old('address') }}"
                maxlength="300"
                required
            />
            <x-input
                name="postal_code"
                type="text"
                autocomplete="postal-code"
                placeholder="{{ __('Postal Code') }}"
                value="{{ old('postal_code') }}"
                required
            />
            <x-input
                name="city"
                type="text"
                autocomplete="address-level2"
                placeholder="{{ __('City') }}"
                value="{{ old('city') }}"
                required
            />
            <x-input
                name="country"
                type="text"
                autocomplete="country-name"
                placeholder="{{ __('Country') }}"
                value="{{ old('country') }}"
                required
            />
        </div>
    </div>
@endif
