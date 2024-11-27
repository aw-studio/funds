@php
    $defaultAmount = $reward ? $reward->min_amount->get() : 500;
@endphp
<x-public::campaign-layout
    :$campaign
    bodyClass="page-checkout"
>
    <div class="max-w-4xl mx-auto">
        <a
            class="flex items-center text-sm text-gray-500 gap-2 mb-4"
            href="{{ route('campaigns.public.rewards', ['campaign' => $campaign]) }}"
        >
            <x-icons.arrow-left />
            {{ __('Back') }}
        </a>

        <div>
            <p class="text-sm mb-2">{{ __('With your Donation you are supporting the Campaign:') }}</p>
            <h1 class="text-3xl mb-6">{{ $campaign->name }}</h1>
            @if ($reward)
                <div class="reward mb-4">
                    <x-public::checkout.section-headline :value="__('Selected Reward')" />
                    <div class="md:flex gap-2 items-center">
                        @if ($image = $reward->getFirstMedia('image'))
                            <div class="mb-2 md:max-w-48">
                                {{ $image }}
                            </div>
                        @endif
                        <div class="mb-2">
                            <p class="mb-2">{{ $reward->name }}</p>
                            <p>@lang('Donation amount'): {{ $reward->min_amount }}</p>
                        </div>
                    </div>
                </div>
            @else
                <x-public::checkout.section-headline :value="__('Your donation')" />
            @endif
        </div>
        <form
            id="payment-form"
            method="POST"
            action="{{ route('public.checkout.store', ['campaign' => $campaign, 'reward' => $reward]) }}"
            class="mb-12"
            x-data="{
                type: @js(old('donation_type') ?? 'one_time'),
                amount: @js(old('amount') ?? $defaultAmount),
                originalAmount: undefined,
                optionalAmount: 0,
                campaignFees: @js($campaign->fees),
                fees: undefined,
                paysFees: false,
                requiresReceipt: false,
                submitting: false,
                submitEnabled: true,
                name: '',
                shipping_name: '',
                shippingDirty: false,
                init() {},

                get canSubmit() {
                    return this.amount > 0 && this.submitEnabled;
                },
                get totalDonationAmount() {
                    return parseInt(this.amount) + this.optionalAmount;
                },

                get totalFees() {
                    if (!this.paysFees) {
                        return 0;
                    }
                    return (parseInt(this.amount) + this.optionalAmount) * (this.campaignFees / 100);
                },
                get totalAmount() {
                    return this.totalDonationAmount + (this.totalFees);
                }
            }"
        >
            @csrf
            <input
                type="hidden"
                name="amount"
                x-model="totalDonationAmount"
                {{-- we don't trust nobody... the feees are calculated in the backend --}}
            >
            @if ($reward && $reward->variants->isNotEmpty())
                <x-select
                    name="reward_variant"
                    class="bg-transparent max-w-md mb-8"
                    label="{{ __('Select a variant') }}"
                    required
                >
                    <option value="">{{ __('Select a variant') }}</option>
                    @foreach ($reward->variants as $variant)
                        <option
                            value="{{ $variant->id }}"
                            @if (!$variant->is_active) disabled @endif
                        >{{ $variant->name }}</option>
                    @endforeach
                </x-select>
            @endif
            <x-public::checkout.donation-amount
                :$reward
                :$defaultAmount
            />
            <div class="mb-16"></div>
            <x-public::checkout.contact-details />
            <x-public::checkout.shipment-details
                :$reward
                :$countries
            />
            <x-public::checkout.donation-types />
            <div class="payment mb-16">
                <x-public::checkout.section-headline :value="__('Payment')" />
                <x-stripe-payment-elements x-show="type == 'one_time'" />
                <x-public::checkout.sepa-payment-elements x-show="type == 'recurring'" />

            </div>

            <div class="mt-4 mb-8">
                <div class="mb-4">
                    <label class="flex items-center">
                        <input
                            type="checkbox"
                            name="pays_fees"
                            value="1"
                            x-model="paysFees"
                        >
                        <span
                            class="ml-2">{{ __('I would like to pay the fees amounting to :amount% of the donation amount', ['amount' => $campaign->fees]) }}</span>
                    </label>
                </div>
                <div class="mb-8">
                    <label class="flex items-center">
                        <input
                            type="checkbox"
                            name="requires_receipt"
                            value="1"
                            x-model="requiresReceipt"
                        >
                        <span class="ml-2">{{ __('I would like to receive a donation receipt by e-mail') }}</span>
                    </label>
                    <div
                        x-show="requiresReceipt"
                        class="p-4"
                    >
                        <x-public::checkout.receipt-address
                            :$countries
                            :$reward
                        />
                    </div>
                </div>
            </div>

            <x-public::checkout.summary :$reward />

            <div class="my-4 terms mb-16">
                <label for="terms">
                    <input
                        id="terms"
                        type="checkbox"
                        required
                    >
                    <span>
                        @lang('I have read the :terms and accept them', [
                            'terms' => '<a href="' . route('public.legalpage', ['page' => 'terms']) . '" target="_blank" class="underline">' . __('Terms of Service') . '</a>',
                        ]).
                    </span>

                </label>
            </div>

            <button
                id="submit"
                class="flex p-4 mt-4 disabled:opacity-50 fc-button ml-auto"
                @if ($campaign->isRunning()) x-bind:disabled="!canSubmit" @else disabled @endif
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 24 24"
                    aria-hidden="true"
                    class="fill-gray-100 w-6 h-6 mr-2 animate-spin"
                    x-show="submitting"
                >
                    <path
                        d="M12,1A11,11,0,1,0,23,12,11,11,0,0,0,12,1Zm0,19a8,8,0,1,1,8-8A8,8,0,0,1,12,20Z"
                        opacity=".25"
                    />
                    <path
                        d="M10.14,1.16a11,11,0,0,0-9,8.92A1.59,1.59,0,0,0,2.46,12,1.52,1.52,0,0,0,4.11,10.7a8,8,0,0,1,6.66-6.61A1.42,1.42,0,0,0,12,2.69h0A1.57,1.57,0,0,0,10.14,1.16Z"
                    />
                </svg>
                {{ __('Donate an amount') }}
            </button>
            @if ($errors->any())
                <div class="text-red-500">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </form>
    </div>
</x-public::campaign-layout>
