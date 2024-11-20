<x-app-layout
    :backRoute="route('donations.index')"
    :title="page_title(__('Edit Receipt Address'))"
>
    <x-form-page-container :title="__('Edit Receipt Address')">
        <form
            action="{{ route('donations.receipt-address.update', $donation) }}"
            method="POST"
            class="space-y-4"
        >
            @csrf
            @method('PUT')
            <x-input
                label="Name"
                name="name"
                value="{{ $donation->receipt_address['name'] ?? '' }}"
                required
            />
            <x-input
                label="Address"
                name="address"
                value="{{ $donation->receipt_address['address'] ?? '' }}"
                required
            />
            <div class="grid grid-cols-2 gap-2">
                <x-input
                    label="Postal Code"
                    name="postal_code"
                    value="{{ $donation->receipt_address['postal_code'] ?? '' }}"
                    required
                />
                <x-input
                    label="City"
                    name="city"
                    value="{{ $donation->receipt_address['city'] ?? '' }}"
                    required
                />
            </div>
            <x-input
                label="Country"
                name="country"
                value="{{ $donation->receipt_address['country'] ?? '' }}"
                required
            />
            <div class="my-10">
                <x-button
                    outlined
                    :href="route('donations.show', $donation)"
                    wire:navigate
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
