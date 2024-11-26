<?php
use Funds\Foundation\Facades\Funds;
?>
@if (count(Funds::donationTypes()) == 1)
    @foreach (Funds::donationTypes() as $key => $type)
        <input
            type="hidden"
            name="donation_type"
            value="{{ $key }}"
        >
    @endforeach
@endif

@if (count(Funds::donationTypes()) > 1)
    <div class="my-10">
        <x-public::checkout.section-headline :value="__('Select Donation Type')" />
        <p class="">{{ __('Select the type of donation you would like to make') }}</p>
        <div class="flex gap-2 my-5">
            @foreach (Funds::donationTypes() as $key => $type)
                <label
                    class="card-radio flex items-center border p-4 mb-2 cursor-pointer min-w-48 text-center justify-center"
                    :class="{
                        'selected': type === @js($key),
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
                            <small class="text-xs pb-1">
                                {{ __('donate_' . $key . '_label') }}
                            </small>
                        @endif
                        <span class="ml-2">
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
