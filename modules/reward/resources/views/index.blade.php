<x-campaign::layout>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
        <div class="col-span-3 items-end flex">
            <x-button
                class="ml-auto"
                href="{{ route('rewards.create') }}"
            >
                {{ __('Create Reward') }}
            </x-button>
        </div>
        @forelse ($rewards as $reward)
            <x-rewards::reward-item :$reward />
        @empty
            <p>No rewards found.</p>
        @endforelse
    </div>

</x-campaign::layout>
