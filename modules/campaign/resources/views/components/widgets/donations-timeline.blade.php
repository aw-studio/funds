<div class="bg-gray-50 overflow-hidden sm:rounded-lg p-4">
    <div class="mb-4">
        <span class="font-serif font-semibold text-xl">
            {{ __('Donation Progress') }}
        </span>
    </div>
    <livewire:donations-timeline-chart :campaign="$campaign" />
</div>
