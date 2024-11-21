<?php

use function Livewire\Volt\{state};
use Funds\Donation\Models\Donation;
use function Livewire\Volt\{with, usesPagination};

state(['reward']);

$deleteReward = function () {
    try {
        $this->reward->delete();
    } catch (\Exception) {
        flash(__('Unable to delete reward.'), 'error');

        return redirect()->back();
    }

    flash(__('Reward deleted.'), 'info');
    $this->redirect(route('rewards.index'));
};
?>

<div>
    <x-button
        outlined
        wire:click="deleteReward"
        wire:confirm="Are you sure you want to delete this Reward?"
    >
        {{ __('Delete Reward') }}
    </x-button>
</div>
