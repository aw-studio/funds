<x-campaign::layout :campaign="$campaign">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
        <x-campaign::widgets.campaign-info :campaign="$campaign" />
        <x-campaign::widgets.donations :campaign="$campaign" />
        <x-campaign::widgets.top-rewards
            :rewards="$rewards"
            :campaign="$campaign"
        />
        <x-campaign::widgets.average-donation :$averageDonationAmount />
        <x-campaign::widgets.max-donation :$maxDonationAmount />
        <x-campaign::widgets.donation-sum :$adjustedTotalAmount />
        <div class="col-span-full">
            <x-campaign::widgets.donations-timeline :campaign="$campaign" />
        </div>
    </div>
</x-campaign::layout>
