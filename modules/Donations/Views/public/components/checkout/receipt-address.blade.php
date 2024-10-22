@props([
    'countries' => [],
    'reward' => null,
])
<div x-data="{
    useShippingAddress: false,
}">
    @if ($reward)
        <label class="flex items-center">
            <input
                type="checkbox"
                name="use_shipping_address_for_receipt"
                value="1"
                x-model="useShippingAddress"
            >
            <span class="ml-2">{{ __('Use my shipping address') }}</span>
        </label>
    @endif

    <div
        x-show="!useShippingAddress"
        class="my-8"
    >
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
            <div>
                <x-input
                    id="receipt_name"
                    type="text"
                    name="receipt_name"
                    :label="__('Full name')"
                    class="mb-4"
                />
                <x-input
                    id="receipt_address"
                    type="text"
                    name="receipt_address"
                    :label="__('Street address')"
                    class="mb-4"
                />
                <div class="grid grid-cols-3 gap-2">
                    <div class="col-span-1">
                        <x-input
                            id="receipt_postal_code"
                            type="text"
                            name="receipt_postal_code"
                            :label="__('Postal code')"
                        />
                    </div>
                    <div class="col-span-2">
                        <x-input
                            id="receipt_city"
                            type="text"
                            name="receipt_city"
                            :label="__('City')"
                        />

                    </div>
                </div>
                <x-input
                    id="organization"
                    type="text"
                    name="organization"
                    :label="__('Organization')"
                    class="mb-4"
                />
                <x-select
                    id="receipt_country"
                    name="receipt_country"
                    :label="__('Country')"
                    class="md:max-w-1/2"
                >
                    @foreach ($countries as $code => $country)
                        <option value="{{ $code }}">{{ $country }}</option>
                    @endforeach
                </x-select>
            </div>
        </div>
    </div>

</div>
