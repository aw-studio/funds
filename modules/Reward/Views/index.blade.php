<x-campaign-layout>
    <div class="grid md:grid-cols-3 gap-4">
        <div class="col-span-3 items-end flex">
            <x-button
                class="ml-auto"
                href="{{ route('rewards.create') }}"
            >
                {{ __('Create Reward') }}
            </x-button>
        </div>
        @forelse ($rewards as $reward)
            <a
                href="{{ route('rewards.edit', $reward) }}"
                class="bg-white overflow-hidden shadow-sm sm:rounded-lg grid grid-cols-3"
            >
                <div class="bg-gray-200 min-w-sm">
                    @if ($reward->getFirstMedia('image'))
                        <img
                            src="{{ $reward->getFirstMediaUrl('image', 'thumb') }}"
                            class="w-full h-full object-cover"
                        />
                    @endif
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
