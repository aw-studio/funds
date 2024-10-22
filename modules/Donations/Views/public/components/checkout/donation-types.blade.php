<?php
use Funds\Foundation\Facades\Funds;
?>
@if (count(Funds::donationTypes()) > 1)
    <div class="my-10">
        <p class="checkout-section-header text-2xl mb-4"> {{ __('Select Donation Type') }}</p>
        <p class="">{{ __('Select the type of donation you would like to make') }}</p>
        <div class="flex gap-2 my-5">
            @foreach (Funds::donationTypes() as $key => $type)
                <label
                    class="flex items-center border p-4 mb-2 cursor-pointer card-radio min-w-48 text-center justify-center"
                    :class="{
                        'border-accent-1': type === @js($key),
                        'border-color-input': type !== @js($key)
                    }"
                >
                    <input
                        type="radio"
                        name="donation_type"
                        value="{{ $key }}"
                        x-model="type"
                        class="hidden"
                    >
                    <p class="flex flex-col">
                        @if (Lang::has('donate_' . $key . '_label'))
                            <span class="text-sm pb-1">
                                {{ __('donate_' . $key . '_label') }}
                            </span>
                        @endif
                        <span
                            class="ml-2"
                            :class="{
                                'text-accent-1': type === @js($key),
                                'text-gray-500': type !== @js($key)
                            }"
                        >
                            {{ __('donate_' . $key) }}
                        </span>
                    </p>
                </label>
            @endforeach
        </div>
    </div>
    @foreach (Funds::donationTypes() as $key => $type)
        @if (View::exists('public::components.checkout.donation_type_' . $key))
            <div
                x-show="type === @js($key)"
                class="mb-8"
            >
                <x-dynamic-component :component="'public::checkout.donation_type_' . $key" />
            </div>
        @endif
    @endforeach
@endif
