@if ($donation->reward)
    <x-card-widget {{ $attributes->only('class') }}>
        <span class="text-gray-500 text-sm">{{ __('Selected Reward') }}</span>
        <div class="text-xl font-serif">
            {{ $donation->reward->name }}
        </div>
        <div class="mt-2">
            @if ($donation->rewardVariant)
                <p class="flex gap-2 items-center">
                    <x-icons.tag />
                    {{ $donation->rewardVariant->name }}
                </p>
            @endif
        </div>
    </x-card-widget>
@endif
