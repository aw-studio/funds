<x-app-layout
    :backRoute="route('donations.show', $order->donation_id)"
    :title="page_title(__('Edit Order'))"
>
    <x-form-page-container :title="__('Edit Order')">
        <form
            action="{{ route('orders.update', $order) }}"
            method="POST"
            class="space-y-4"
        >
            @csrf
            @method('PUT')
            <x-select
                label="Reward"
                name="reward"
                required
            >
                @foreach ($rewards as $reward)
                    <option
                        value="{{ $reward->id }}"
                        {{ $reward->id === $order->reward_id ? 'selected' : '' }}
                    >
                        {{ $reward->name }}
                    </option>
                @endforeach
            </x-select>
            @if ($order->reward->variants->count() > 0)
                <x-select
                    label="Reward Variant"
                    name="reward_variant"
                >
                    <option value="">@lang('No variant')</option>
                    @foreach ($order->reward->variants as $variant)
                        <option
                            value="{{ $variant->id }}"
                            {{ $variant->id === $order->reward_variant_id ? 'selected' : '' }}
                        >
                            {{ $variant->name }}
                        </option>
                    @endforeach
                </x-select>
            @endif

            <x-textarea
                label="Note"
                name="note"
                value="{{ $order->note }}"
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
