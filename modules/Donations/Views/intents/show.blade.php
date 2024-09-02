<?php
use function Livewire\Volt\{state};

state(['intent']);

$confirm = function () {
    $this->intent->succeed();

    return redirect()->route('donations.show', ['donation' => $this->intent->donation]);
};

?>
<x-campaign-layout :backRoute="route('donations.intents.index')">
    <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200">
        {{ __('Donation Intent') }} #{{ $intent->id }}
    </h2>
    <div class="p-6 text-gray-900 dark:text-gray-100">
        @dump($intent->toArray())

        @if ($intent->type == 'recurring')
            {{ $intent->recurring_donation_data['frequency'] }}
            {{ $intent->recurring_donation_data['amount'] }}
            {{ $intent->recurring_donation_data['payment']['iban'] }}

            @volt('confirmRecurringDonationIntent')
                <div>
                    <button wire:click="confirm">{{ __('Confirm') }}</button>
                </div>
            @endvolt
        @endif
    </div>

</x-campaign-layout>
