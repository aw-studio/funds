<?php

use function Livewire\Volt\{state};
use Funds\Donations\Models\Donation;
use function Livewire\Volt\{with, usesPagination};

state(['reward', 'new_variant_name', 'edit_variant', 'edit_variant_name']);

$storeVariant = function () {
    $validated = $this->validate([
        'new_variant_name' => ['required', 'string', 'max:255'],
    ]);

    $this->reward->variants()->create([
        'name' => $this->pull('new_variant_name'),
    ]);
};

$removeVariant = function ($id) {
    $this->reward->variants()->find($id)->delete();
};

$editVariant = function ($id) {
    $this->edit_variant = $this->reward->variants()->find($id);
    $this->edit_variant_name = $this->edit_variant->name;
};

$updateVariant = function () {
    $this->edit_variant->update([
        'name' => $this->edit_variant_name,
    ]);

    $this->reset(['edit_variant_name', 'edit_variant']);
};

$cancelEdit = function () {
    $this->reset(['edit_variant_name', 'edit_variant']);
};
?>

<section>
    <div>
        <span class="text-2xl font-semibold mb-4">{{ __('Variants') }}</span>
    </div>
    @foreach ($reward->variants as $variant)
        <div @class([
            'flex border border-gray-200 justify-between rounded-md p-2 px-4 mb-2',
            'bg-gray-100 border-blue-100' => $edit_variant?->id === $variant->id,
        ])>
            @if ($edit_variant?->id === $variant->id)
                <div
                    x-data="{ isEditing: true }"
                    x-init="$nextTick(() => $refs.input.focus())"
                >
                    <input
                        placeholder="{{ __('Edit Reward variant') }}..."
                        wire:model="edit_variant_name"
                        wire:keydown.enter.prevent="updateVariant"
                        wire:keydown.escape="cancelEdit"
                        wire:click.away="cancelEdit"
                        x-ref="input"
                        class="w-full border-none p-0 focus:ring-0 bg-transparent"
                    />
                </div>
            @else
                <span
                    class="cursor-pointer"
                    wire:click="editVariant({{ $variant->id }})"
                >{{ $variant->name }}</span>
            @endif
            <span
                class="cursor-pointer"
                wire:click="removeVariant({{ $variant->id }})"
                wire:confirm="Are you sure you want to delete this variant?"
            >&times;</span>
        </div>
    @endforeach
    <x-input
        placeholder="{{ __('Add Reward variant') }}..."
        wire:model="new_variant_name"
        wire:keydown.enter.prevent="storeVariant"
    />
</section>
