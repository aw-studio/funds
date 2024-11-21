@props(['reward'])
{{-- TODO: There should be a better solution than including this modal for every item... --}}
<x-modal
    name="confirm-reward-deletion-{{ $reward->id }}"
    focusable
>
    <form
        class="p-6"
        action="{{ route('rewards.destroy', $reward) }}"
        method="POST"
    >
        @csrf
        @method('DELETE')
        <h2 class="text-xl font-serif font-medium text-black">
            {{ __('Delete Reward') }}
        </h2>

        <p class="mt-1">
            {{ __('If you delete this reward, you will not be able to access it again. Delete it anyway?') }}
        </p>

        <div class="mt-6 flex justify-end">
            <x-button
                outlined
                type="button"
                x-on:click="$dispatch('close')"
            >
                {{ __('Cancel') }}
            </x-button>

            <x-button class="ms-3">
                {{ __('Delete') }} {{ $reward->name }}
            </x-button>
        </div>
    </form>
</x-modal>
