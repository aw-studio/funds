<x-card {{ $attributes->only('class') }}>
    <span class="text-gray-500 text-sm">{{ __('Type') }}</span>
    <div class="text-xl font-serif">
        {{ $donation->label() }}
    </div>
</x-card>
