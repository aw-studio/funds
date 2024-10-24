<x-campaign::layout :campaign="$campaign">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
        <x-campaign::widgets.campaign-info :campaign="$campaign" />
        <x-campaign::widgets.donations :campaign="$campaign" />
        <x-campaign::widgets.top-rewards :rewards="$rewards" />
        <x-campaign::widgets.average-donation :campaign="$campaign" />
        <x-campaign::widgets.donation-sum :$adjustedTotalAmount />
    </div>
</x-campaign::layout>
