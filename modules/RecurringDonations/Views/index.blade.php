<x-app-layout>
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        @include('recurring-donations::header', ['title' => __('Recurring Donations')])
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
                            Recurring Amount
                        </th>
                        <th
                            class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                            Frequency
                        </th>
                        <th
                            class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                @foreach ($donations as $donation)
                    <tr>
                        {{-- <td>{{ $recurringDonationIntent->id }}</td> --}}
                        <td>{{ $donation->amount }}</td>
                        <td>
                            @dump($donation)
                        </td>
                        {{-- <td>{{ $donation->created_at }}</td>
                        <td>{{ $donation->recurring_donation_data['amount'] }}</td>
                        <td>{{ $donation->recurring_donation_data['frequency'] }}</td>
                        <td>{{ $donation->recurring_donation_data['payment']['iban'] }}</td> --}}
                        <td></td>
                    </tr>
                    {{-- @dump($recurringDonationIntent->toArray()) --}}
                @endforeach
            </table>
        </div>
    </div>
</x-app-layout>
