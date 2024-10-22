<x-campaigns::layout :campaign="$campaign">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
        <x-campaigns::widgets.campaign-info :campaign="$campaign" />
        <x-campaigns::widgets.donations :campaign="$campaign" />
        <x-campaigns::widgets.top-rewards :rewards="$rewards" />
        <x-campaigns::widgets.average-donation :campaign="$campaign" />
        <x-campaigns::widgets.donation-sum :$adjustedTotalAmount />
    </div>
</x-campaigns::layout>
