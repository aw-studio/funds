<x-campaign::layout>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
        <div class="col-span-3 items-end flex">
            <x-button
                class="ml-auto"
                :href="route('rewards.create')"
                wire:navigate
            >
                {{ __('Create Reward') }}
            </x-button>
        </div>
        @empty($rewards)
            <p>No rewards found.</p>
        @endempty

        <div class="col-span-full">
            <x-section-headline :value="__('Enabled Rewards')" />
        </div>
        @foreach ($rewards->where('is_active', true) as $reward)
            <x-rewards::reward-item :$reward />
        @endforeach

        <div class="col-span-full mt-10">
            <x-section-headline :value="__('Disabled Rewards')" />
        </div>
        @foreach ($rewards->where('is_active', false) as $reward)
            <x-rewards::reward-item :$reward />
        @endforeach
    </div>

</x-campaign::layout>
