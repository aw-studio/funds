@props(['reward', 'countries' => []])
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
                name="street"
                autocomplete="street-address"
                placeholder="{{ __('Street Address') }}"
                value="{{ old('street') }}"
                maxlength="300"
                required
            />
            <x-input
                name="address_addition"
                type="text"
                placeholder="{{ __('Address Addition') }}"
                value="{{ old('address_addition') }}"
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

            <x-select
                name="country"
                required
                autocomplete="countryCode"
            >
                <option value="">{{ __('Country') }}</option>
                @foreach ($countries as $countryCode => $country)
                    <option
                        value="{{ $countryCode }}"
                        name="countryCode"
                        {{ old('countryCode') == $countryCode ? 'selected' : '' }}
                    >{{ $country }}</option>
                @endforeach
            </x-select>

        </div>
    </div>
@endif
