@props(['reward', 'countries' => []])
@if ($reward !== null)
    <div class="shipmentDetails mb-16">
        <x-public::checkout.section-headline :value="__('Shipping address')" />
        <div class="grid md:grid-cols-6 gap-x-8  gap-y-4 mb-5 ">
            <x-input
                name="shipping_name"
                type="text"
                placeholder="Jane Doe"
                value="{{ old('shipping_name') }}"
                autocomplete="name"
                label="{{ __('Full name') }}"
                required
                x-model="shipping_name"
                x-on:input="shippingDirty = true"
                wrapperClass="col-span-3"
            />

            <x-input
                name="street"
                autocomplete="street-address"
                placeholder="{{ __('Street address') }}"
                label="{{ __('Street address') }}"
                value="{{ old('street') }}"
                maxlength="300"
                required
                wrapperClass="col-start-1 col-span-3"
            />
            <x-input
                name="address_addition"
                type="text"
                placeholder="{{ __('Address addition') }}"
                label="{{ __('Address addition') }}"
                value="{{ old('address_addition') }}"
                class="mb-2"
                wrapperClass="col-span-2"
            />
            <x-input
                name="postal_code"
                type="text"
                autocomplete="postal-code"
                placeholder="{{ __('Postal code') }}"
                label="{{ __('Postal code') }}"
                value="{{ old('postal_code') }}"
                required
                wrapperClass="col-start-1 md:col-span-2"
            />
            <x-input
                name="city"
                type="text"
                autocomplete="address-level2"
                placeholder="{{ __('City') }}"
                label="{{ __('City') }}"
                value="{{ old('city') }}"
                required
                wrapperClass="col-span-2 md:col-span-3"
            />

            <div class="mb-2 col-span-3">
                <x-country-select selectedOption="{{ old('country') }}" />
            </div>

        </div>
    </div>
@endif
