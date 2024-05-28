<x-campaigns::public.layout title="{{ $campaign->name }}">
    <div>
        <h1 class="text-2xl font-semibold">{{ $campaign->name }}</h1>
        @if ($reward)
            {{ __('Selected reward') }}:
            <div class="bg-gray-50 my-4 p-4 shadow-md ronded-md">
                {{ $reward->name }}
                {{ $reward->min_amount }}
            </div>
        @else
        @endif
    </div>
    <main>
        {{-- included so alpine.js will be available --}}
        <livewire:checkout
            :campaign="$campaign"
            :reward="$reward"
        />
        {{--  --}}
        <form
            id="payment-form"
            method="POST"
            action="{{ route('public.checkout.store', ['campaign' => $campaign, 'reward' => $reward]) }}"
            x-data="{ type: @js(old('donation_type') ?? 'onetime') }"
        >
            @csrf
            <x-donations::checkout.donation-amount :$reward />
            <x-donations::checkout.contact-details />
            <x-donations::checkout.shipment-details :$reward />
            <x-donations::checkout.donation-types />
            <div>
                <h1 class="font-semibold">Payment</h1>
                <x-stripe-payment-elements x-show="type == 'onetime'" />
                <x-donations::checkout.sepa-payment-elements x-show="type == 'recurring'" />
                <div class="mt-4">
                    <label class="flex items-center">
                        <input
                            type="checkbox"
                            name="cover_fees"
                            value="1"
                        >
                        <span class="ml-2">{{ __('Cover processing fees') }}</span>
                    </label>
                </div>
            </div>
            <button
                id="submit"
                class="bg-primary-500 text-white p-4 rounded-lg mt-4 disabled:opacity-50"
            >{{ __('Donate now') }}</button>
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
