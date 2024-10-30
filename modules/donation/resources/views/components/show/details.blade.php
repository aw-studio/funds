<x-card-widget class="mb-4">
    <div class="">
        <p class="text-sm">{{ __('Transaction') }}</p>
        <div class="text-xl font-bold font-serif mb-2">
            {{ $donation->amount }}
        </div>
    </div>
    <hr class="my-8" />
    <div class="space-y-2">
        <div class="flex gap-2">
            <x-icons.calendar />
            {{ $donation->created_at->isoFormat('L LT') }}
        </div>
        <div class="flex gap-2">
            <x-icons.rotate />
            {{ $donation->type->label() }}
        </div>
        <div class="flex gap-2">
            @if ($donation->paidFees())
                <x-icons.square-percent />
                <span>{{ $donation->paidFeeAmount() }} ({{ $donation->campaign->fees }}%)
                    {{ __('Transaction fees paid') }}</span>
            @endif
        </div>
    </div>
    <hr class="my-8" />
    @if ($donation->receipt_address)
        <div class="relative">
            <span class="text-sm text-gray-500">{{ __('Receipt address') }}</span>
            <x-button
                round
                outlined
                class="w-8 h-8 items-center justify-center flex !p-0 absolute top-2 right-8"
                href="{{ route('donations.receipt-address.edit', $donation) }}"
            >
                <x-icons.pencil class="w-4 h-4" />
            </x-button>
            <div class="text-base">
                {{ $donation->receipt_address['name'] }}<br />
                {{ $donation->receipt_address['address'] }} <br />
                {{ $donation->receipt_address['postal_code'] }}
                {{ $donation->receipt_address['city'] }} <br />
                {{ $donation->receipt_address['country'] }}
            </div>
            <div class="my-8">
                <div class="bg-gray-50 p-4 inline-flex items-center justify-between gap-2 rounded-xl">
                    <x-icons.paperclip />
                    <a
                        href="{{ route('donations.receipt', $donation) }}"
                        class="flex gap-4"
                    >
                        {{ __('Download receipt') }}
                        <x-icons.download />
                    </a>

                </div>
            </div>

        </div>
    @endif

</x-card-widget>
