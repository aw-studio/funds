<x-app-layout
    {{-- :backRoute="route('donations.show', $order->donation_id)" --}}
    :title="page_title(__('Create Order'))"
>
    <x-form-page-container :title="__('Create Order')">
        <form
            action="{{ route('orders.store') }}"
            method="POST"
            class="space-y-4"
            x-data="{
                selectedReward: null,
                rewards: @js($rewards),
                onVariantChange(event) {
                    this.selectedReward = parseInt(event.target.value);
                },
                get variants() {
                    if (!this.selectedReward) {
                        return [];
                    }

                    return this.rewards.find(reward => reward.id === this.selectedReward)?.variants;
                },
            }"
        >
            @csrf
            <input
                name="donation_id"
                type="hidden"
                value="{{ $donationId }}"
            />
            <x-select
                label="{{ __('Reward') }}"
                name="reward"
                required
                x-on:change="onVariantChange"
            >
                @foreach ($rewards as $reward)
                    <option value="{{ $reward->id }}">
                        {{ $reward->name }}
                    </option>
                @endforeach
            </x-select>
            <div x-show="variants.length > 0">
                <x-select
                    label="{{ __('Variant') }}"
                    name="reward_variant"
                >
                    <option value="">@lang('No variant')</option>
                    <template
                        x-for="variant in variants"
                        :key="variant.id"
                    >
                        <option
                            x-text="variant.name"
                            :value="variant.id"
                        ></option>
                    </template>

                </x-select>
            </div>

            <x-textarea
                label="Note"
                name="note"
            />
            <x-input
                label="Name"
                name="name"
                required
            />
            <x-input
                label="Street Address"
                name="street"
                required
            />
            <x-input
                label="Address addition"
                name="address_addition"
            />
            <div class="grid grid-cols-2 gap-2">
                <x-input
                    label="Postal Code"
                    name="postal_code"
                    required
                />
                <x-input
                    label="City"
                    name="city"
                    required
                />
            </div>

            <x-country-select
                label="Country"
                name="country"
                required
            />

            <div class="my-10">
                <x-button
                    outlined
                    href="{{ route('donations.show', $donationId) }}"
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
