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
        <pre>{{ json_encode($intent->toArray(), JSON_PRETTY_PRINT) }} </pre>

        @volt('confirmRecurringDonationIntent')
            <div>
                <x-button wire:click="confirm">{{ __('Confirm') }}</x-button>
            </div>
        @endvolt
    </div>

</x-campaign-layout>
