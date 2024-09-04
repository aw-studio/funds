<x-campaigns::public.layout :$campaign>
    <div>
        <h1 class="text-2xl font-semibold">{{ $campaign->name }}</h1>
        @if ($reward)
            {{ __('Selected reward') }}:
            <div class="bg-gray-50 my-4 p-4 shadow-md ronded-md">
                {{ $reward->name }}
                {{ $reward->min_amount }}
            </div>
        @endif
    </div>
    <main>
        @php
            $defaulAmount = $reward ? $reward->min_amount->get() : 1000;
        @endphp
        <form
            id="payment-form"
            method="POST"
            action="{{ route('public.checkout.store', ['campaign' => $campaign, 'reward' => $reward]) }}"
            x-data="{
                type: @js(old('donation_type') ?? 'onetime'),
                amount: @js(old('amount') ?? $defaulAmount),
                originalAmount: undefined,
                fees: undefined,
                submitEnabled: true,
                paysFees: false,
                init() {
                    this.fees = this.amount * 0.03;

                    this.$watch('amount', () => {
                        this.fees = this.amount * 0.03;
                    });
                },
                get totalAmount() {
                    return parseInt(this.amount) + (this.paysFees ? this.fees : 0);
                }
            }"
        >
            @csrf
            @if ($reward && $reward->variants->isNotEmpty())
                <x-select name="reward_variant">
                    @foreach ($reward->variants as $variant)
                        <option value="{{ $variant->id }}">{{ $variant->name }}</option>
                    @endforeach
                </x-select>
            @endif

            <x-donations::checkout.donation-amount :$reward />
            <x-donations::checkout.contact-details />
            <x-donations::checkout.shipment-details
                :$reward
                :$countries
            />
            <x-donations::checkout.donation-types />
            <div>
                <h1 class="font-semibold">Payment</h1>
                <x-stripe-payment-elements x-show="type == 'onetime'" />
                <x-donations::checkout.sepa-payment-elements x-show="type == 'recurring'" />
                <div class="mt-4">
                    <label class="flex items-center">
                        <input
                            type="checkbox"
                            name="pays_fees"
                            value="1"
                            x-model="paysFees"
                        >
                        <span class="ml-2">{{ __('Cover processing fees') }}</span>
                    </label>
                </div>
            </div>

            <div class="bg-gray-100 p-2 ">
                <span class="text-xl"> {{ __('Summary') }}</span>
                @if ($reward)
                    <div class="flex justify-between">
                        <span>{{ __('Reward') }}</span>
                        <span>{{ $reward->name }}</span>
                    </div>
                @endif
                <div class="flex justify-between">
                    <span>{{ __('Donation amount') }}</span>
                    <span x-money="amount"></span>
                </div>
                <div x-show="paysFees">
                    <div class="flex justify-between">
                        <span>{{ __('Processing fees') }}</span>
                        <span x-money="fees"></span>
                    </div>
                </div>
                <div class="flex justify-between">
                    <span x-uppercase>{{ __('Total amount') }}</span>
                    <span x-money="totalAmount"></span>
                </div>
            </div>

            <button
                id="submit"
                class="flex bg-primary-500 text-white p-4 rounded-lg mt-4 disabled:opacity-50"
                :disabled="!submitEnabled"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 24 24"
                    aria-hidden="true"
                    class="fill-gray-100 w-6 h-6 mr-2 animate-spin"
                    x-show="!submitEnabled"
                >
                    <path
                        d="M12,1A11,11,0,1,0,23,12,11,11,0,0,0,12,1Zm0,19a8,8,0,1,1,8-8A8,8,0,0,1,12,20Z"
                        opacity=".25"
                    />
                    <path
                        d="M10.14,1.16a11,11,0,0,0-9,8.92A1.59,1.59,0,0,0,2.46,12,1.52,1.52,0,0,0,4.11,10.7a8,8,0,0,1,6.66-6.61A1.42,1.42,0,0,0,12,2.69h0A1.57,1.57,0,0,0,10.14,1.16Z"
                    />
                </svg>
                {{ __('Donate now') }}
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
    </main>
</x-campaigns::public.layout>
