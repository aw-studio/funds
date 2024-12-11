<div class="bg-gray-50  overflow-hidden  sm:rounded-lg">
    <div class="p-6 text-black text-sm">
        <span class="text-lg">
            {{ __('Top Rewards') }}
        </span>
        <div>
            <livewire:top-rewards-forecast :campaign="$campaign" />
        </div>
    </div>
</div>
