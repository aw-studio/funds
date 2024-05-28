<x-campaign-layout>
    <x-slot name="actions">
        <x-primary-button
            class="ml-auto"
            href="{{ route('rewards.create') }}"
        >
            {{ __('Create Reward') }}
        </x-primary-button>
    </x-slot>
    <div class="grid md:grid-cols-3 gap-4">
        @forelse ($rewards as $reward)
            <a
                href="{{ route('rewards.show', $reward) }}"
                wire:navigate
                class="bg-white overflow-hidden shadow-sm sm:rounded-lg grid grid-cols-3"
            >
                <div class="bg-gray-200 ">
                </div>
                <div class="p-6 text-gray-900 dark:text-gray-100 col-span-2">
                    <h3 class="text-lg font-semibold">
                        {{ $reward->name }}
                    </h3>
                    <p class="text-3xl font-semibold">
                    <p>{{ $reward->description }}</p>
                    <p>{{ $reward->min_amount }}</p>
                    </p>
                </div>
            </a>
        @empty
            <p>No rewards found.</p>
        @endforelse
    </div>

</x-campaign-layout>
