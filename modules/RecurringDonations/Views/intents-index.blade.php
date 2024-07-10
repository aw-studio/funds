<?php
use function Livewire\Volt\{state};

state(['intent']);

$confirm = function () {
    $this->intent->succeed();

    return redirect()->route('donations.show', ['donation' => $this->intent->donation]);
};

?>
<x-app-layout>
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        @include('recurring-donations::header', ['title' => __('Recurring Donation Intents')])
        <div class="p-4 bg-white shadow rounded-lg">

            <table class="min-w-full">
                <thead>
                    <tr>
                        {{-- <th
                            class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                            ID
                        </th> --}}
                        <th
                            class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                            Amount
                        </th>
                        <th
                            class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                            Email
                        </th>

                        <th
                            class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                            Recurring Amount
                        </th>
                        <th
                            class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                            Frequency
                        </th>
                        <th
                            class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                            IBAN
                        </th>
                        <th
                            class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                            Created At
                        </th>
                        <th
                            class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                @foreach ($intents as $recurringDonationIntent)
                    <tr>
                        {{-- <td>{{ $recurringDonationIntent->id }}</td> --}}
                        <td>{{ $recurringDonationIntent->amount }}</td>
                        <td>{{ $recurringDonationIntent->email }}</td>
                        <td>{{ $recurringDonationIntent->recurring_donation_data['amount'] }}</td>
                        <td>{{ $recurringDonationIntent->recurring_donation_data['frequency'] }}</td>
                        <td>{{ $recurringDonationIntent->recurring_donation_data['payment']['iban'] }}</td>
                        <td>{{ $recurringDonationIntent->created_at->isoFormat('L LT') }}</td>
                        <td>
                            <form
                                method="POST"
                                action="{{ route('recurring-donations.intents.confirm', ['intent' => $recurringDonationIntent]) }}"
                            >
                                @csrf
                                <button
                                    type="submit"
                                    class="bg-tangerine-400 text-white px-4 py-2 rounded-lg text-sm font-semibold"
                                >
                                    {{ __('Confirm') }}
                                </button>
                            </form>

                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
</x-app-layout>
