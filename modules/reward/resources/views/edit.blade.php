{{-- @props(['campaign', 'actions' => null, 'backRoute' => null]) --}}
<x-app-layout>
    <x-form-page-container :title="__('Edit Reward')">
        <form
            action="{{ route('rewards.update', $reward) }}"
            method="POST"
            enctype="multipart/form-data"
        >
            @csrf
            @method('PUT')
            <div class="mb-4">
                <span class="text-xl mb-4">
                    {{ __('General') }}
                </span>
            </div>
            <div class="grid grid-cols-2 gap-2 mb-4">
                <x-input
                    name="name"
                    :value="$reward->name"
                    :label="__('Name')"
                    placeholder="{{ __('Reward Name') }}"
                    required
                />
                <x-input-money
                    name="min_amount"
                    :value="$reward->min_amount->get()"
                    :label="__('Donation amount in €')"
                    placeholder="0.00"
                />
            </div>
            <div class="mb-4">
                <x-textarea
                    name="description"
                    :label="__('Description')"
                    :value="$reward->description"
                    required
                />
            </div>
            <x-input-image
                name="image"
                label="{{ __('Upload image') }}"
                hint="{{ 'The maximum file size is 5 MB. Supported file formats are .jpg and .png.' }}"
                class="md:max-w-sm mb-10"
                currentUrl="{{ $reward->getFirstMediaUrl('image', 'thumb') }}"
            />

            <div class="max-w-md mt-10">
                <livewire:reward-variants :reward="$reward" />
            </div>
            <div class="mt-10">
                <p class="text-xl mb-4">{{ __('Shipment Settings') }}</p>
            </div>
            <div class="mb-4">
                <x-input-label
                    :value="__('Shipping Type')"
                    for="shipping_type"
                />
                <x-rewards::shipping-type-select :selected="$reward->shipping_type" />
            </div>
            @if ($errors->any())
                {{ implode('', $errors->all('<div>:message</div>')) }}
            @endif
            <x-textarea
                name="packaging_instructions"
                :label="__('Shipping Details')"
                class="mb-4"
            >{{ $reward->packaging_instructions }}</x-textarea>
            <div class="flex items-end gap-4">

                <x-button
                    outlined
                    :href="route('rewards.index')"
                    wire:navigate
                >
                    {{ __('Cancel') }}
                </x-button>

                <x-button type="submit">
                    {{ __('Update') }}
                </x-button>
            </div>
        </form>
    </x-form-page-container>
</x-app-layout>
