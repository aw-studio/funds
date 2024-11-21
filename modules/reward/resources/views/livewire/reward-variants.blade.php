<?php

use function Livewire\Volt\{state};
use Funds\Donation\Models\Donation;
use function Livewire\Volt\{with, usesPagination};

state(['reward', 'new_variant_name', 'edit_variant', 'edit_variant_name']);

$storeVariant = function () {
    $validated = $this->validate([
        'new_variant_name' => ['required', 'string', 'max:255'],
    ]);

    $this->reward->variants()->create([
        'name' => $this->pull('new_variant_name'),
    ]);

    $this->dispatch('notify', [
        'message' => __('Variant added successfully.'),
        'type' => 'success',
    ]);
};

$removeVariant = function ($id) {
    $this->reward->variants()->find($id)->delete();
    $this->dispatch('notify', [
        'message' => __('Variant deleted successfully.'),
        'type' => 'success',
    ]);
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

$toggleVariant = function ($id) {
    $this->reward->variants->find($id)->toggle();
    $action = $this->reward->variants->find($id)->is_active ? 'enabled' : 'disabled';
    $this->dispatch('notify', [
        'message' => __('Variant :action successfully.', ['action' => $action]),
        'type' => 'success',
    ]);
};

$cancelEdit = function () {
    $this->reset(['edit_variant_name', 'edit_variant']);
};
?>

<section>
    <div class="mb-4">
        <span class="text-xl">{{ __('Variants') }}</span>
    </div>
    @foreach ($reward->variants as $variant)
        <div class="flex items-center mb-2">
            <div @class([
                'flex flex-grow border border-gray-200 justify-between rounded-md p-2 px-4',
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
                            wire:click.away="updateVariant"
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
            <div class="-mr-10 ml-2">
                <x-input-toggle
                    id="variant-{{ $variant->id }}"
                    wire:change="toggleVariant({{ $variant->id }})"
                    size="sm"
                    :checked="$variant->is_active"
                />
            </div>
        </div>
    @endforeach
    <x-input
        placeholder="{{ __('Add Reward variant') }}..."
        wire:model="new_variant_name"
        wire:keydown.enter.prevent="storeVariant"
    />
</section>
