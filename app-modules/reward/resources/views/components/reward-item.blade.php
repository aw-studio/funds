<div class="grid grid-cols-3 rounded-lg bg-gray-50">
    <div class="bg-gray-200 min-w-sm  rounded-l-lg">
        @if ($reward->getFirstMedia('image'))
            <img
                src="{{ $reward->getFirstMediaUrl('image', 'thumb') }}"
                class="w-full h-full object-cover rounded-l-lg"
            />
        @else
            <x-rewards::placeholder-image class="h-full rounded-l-lg w-full" />
        @endif
    </div>
    <div class="flex col-span-2">
        <div class="p-3">
            <h3 class="text-lg">
                {{ $reward->name }}
            </h3>
            <p>{{ $reward->min_amount }}</p>
            <p class="text-sm">
                {{ __(':count Variants', ['count' => $reward->variants_count]) }}
            </p>
        </div>
        <div class="flex shrink ml-auto p-3">
            <x-dropdown align="right">
                <x-slot name="trigger">
                    <x-button
                        round
                        outlined
                        class="w-10 h-10 !p-0 items-center justify-center"
                    >
                        <x-icons.dots class="text-white" />
                    </x-button>
                </x-slot>

                <x-slot name="content">
                    <x-dropdown-link :href="route('rewards.edit', ['reward' => $reward])">
                        {{ __('Edit Reward') }}
                    </x-dropdown-link>
                    <x-dropdown-link
                        class="cursor-pointer"
                        x-on:click.prevent="$dispatch('open-modal', 'confirm-reward-deletion-{{ $reward->id }}')"
                    >
                        {{ __('Delete Reward') }}
                    </x-dropdown-link>
                </x-slot>
            </x-dropdown>
        </div>
    </div>

    <x-rewards::delete-reward-item-modal :$reward />
</div>
