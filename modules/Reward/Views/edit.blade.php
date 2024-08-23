{{-- @props(['campaign', 'actions' => null, 'backRoute' => null]) --}}
<x-app-layout>
    <x-slot name="header">
        <a
            class="mb-2 flex items-center text-xs text-gray-500"
            href="{{ route('rewards.index') }}"
        >
            <x-icons.arrow-left />
            {{ __('Back') }}
        </a>
        <div class="flex min-h-12 border-b py-2">
            <span class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Edit Reward') }}
            </span>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <form
                action="{{ route('rewards.update', $reward) }}"
                method="POST"
                enctype="multipart/form-data"
            >
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <span class="text-2xl font-semibold mb-4">
                        {{ __('General') }}
                    </span>
                </div>
                <div class="grid grid-cols-2 gap-2 mb-4">
                    <x-input
                        name="name"
                        :value="$reward->name"
                        :label="__('Name')"
                        placeholder="Reward name"
                        required
                    />
                    <x-money-input
                        name="min_amount"
                        :value="$reward->min_amount"
                        :label="__('Donation amount in €')"
                        placeholder="0.00"
                    />
                </div>
                <x-textarea
                    name="description"
                    :label="__('Description')"
                    :value="$reward->description"
                    required
                />
                <x-input-label
                    :value="__('Image')"
                    :hint="__(
                        'Aspect ratio 3:2. The maximum file size is 5 MB. Supported file formats are .jpg and .png.',
                    )"
                />
                <div class="max-w-sm">
                    <x-rewards::reward-image :$reward />
                </div>
                <div class="max-w-md mt-10">
                    <livewire:reward-variants :reward="$reward" />
                </div>
                <div class="mt-10">
                    <span class="text-2xl font-semibold mb-4">{{ __('Shipment Settings') }}</span>
                </div>
                <div>
                    <x-input-label
                        :value="__('Shipping Type')"
                        for="shipping_type"
                    />

                    <select
                        id="HeadlineAct"
                        name="shipping_type"
                        class="mt-1.5 w-full rounded-lg border-gray-300 text-gray-700 sm:text-sm"
                    >
                        <option value="">Please select</option>
                        <option value="JM">Package</option>
                        <option value="SRV">Consignment</option>
                    </select>
                </div>
                <x-textarea
                    name="shipping_details"
                    :label="__('Shipping Details')"
                >{{ $reward->shipping_details ?? '' }}</x-textarea>

                <x-primary-button type="submit">
                    {{ __('Update') }}
                </x-primary-button>
            </form>

            <form
                action="{{ route('rewards.destroy', $reward) }}"
                method="POST"
                onsubmit="return confirm('Are you sure you want to delete this reward?')"
            >
                @csrf
                @method('DELETE')
                <x-primary-button class="bg-red-500">
                    {{ __('Delete Reward') }}
                </x-primary-button>
            </form>

        </div>
    </div>
</x-app-layout>
