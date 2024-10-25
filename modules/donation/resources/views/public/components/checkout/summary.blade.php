@props(['reward' => null])
<div class="p-4 summary">
    <span class="text-xl"> {{ __('Summary') }}</span>
    @if ($reward)
        <div class="flex justify-between py-2">
            <span>{{ $reward->name }}</span>
            <span x-money="{{ $reward->min_amount->get() }}"></span>
        </div>
        <div class="flex justify-between py-2">
            <span>{{ __('Optional amount') }}</span>
            <span x-money="optionalAmount"></span>
        </div>
    @else
        <div class="flex justify-between py-2">
            <span>{{ __('Donation amount') }}</span>
            <span x-money="amount"></span>
        </div>
    @endif

    <div x-show="paysFees">
        <div class="flex justify-between py-2">
            <span>{{ __('Processing fees') }}</span>
            <span x-money="totalFees"></span>
        </div>
    </div>
    <hr class="border-t border-black my-2">
    <div class="flex justify-between py-2">
        <span x-uppercase>{{ __('Total amount') }}</span>
        <span x-money="totalAmount"></span>
    </div>
</div>
