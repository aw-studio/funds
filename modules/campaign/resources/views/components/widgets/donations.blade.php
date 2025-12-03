<div class="bg-gray-50  overflow-hidden  sm:rounded-lg p-4">
    <x-campaign::donut-chart :$campaign />
    <div class="text-center my-4">
        <span class="text-lg">
            {{ __('Total Donations') }}:
            {{ $campaign->donations_count }}
        </span>
    </div>
</div>
