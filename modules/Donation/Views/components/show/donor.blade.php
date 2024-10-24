<div>
    <span class="text-gray-500 text-sm">{{ __('Donor') }}</span>
    <div>
        <p class="text-xl font-serif">{{ $donation->donor->name }}</p>
        <p class="flex gap-2 mt-2 items-center">
            <x-icons.mail />
            {{ $donation->donor->email }}
        </p>
    </div>
</div>
