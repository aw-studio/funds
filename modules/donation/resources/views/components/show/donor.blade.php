<x-card-widget class="mb-8">
    <div class="relative">
        <span class="text-gray-500 text-sm">{{ __('Donor') }}</span>
        <div>
            <p class="text-xl font-serif">{{ $donation->donor->name }}</p>
            <p class="flex gap-2 mt-2 items-center">
                <x-icons.mail />
                {{ $donation->donor->email }}
            </p>
        </div>
        <x-button
            round
            outlined
            href="{{ route('donors.edit', ['donor' => $donation->donor->id, 'previous' => url()->current()]) }}"
            iconButton
            class="w-10 h-10 absolute top-0 right-4"
        >
            <x-icons.pencil />
        </x-button>
    </div>
</x-card-widget>
