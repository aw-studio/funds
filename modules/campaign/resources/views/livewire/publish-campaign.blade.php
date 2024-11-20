<?php

use function Livewire\Volt\{state, computed};
use Funds\Foundation\Facades\Funds;
use Funds\Donation\Models\Donation;

state(['campaign']);

$publish = function () {
    if ($this->campaign->isPublished()) {
        $this->campaign->unpublish();
        $this->dispatch('notify', [
            'message' => __('Campaign unpublished.'),
            'type' => 'success',
        ]);

        return;
    }

    $this->campaign->publish();
    $this->dispatch('notify', [
        'message' => __('Campaign published.'),
        'type' => 'success',
    ]);
};

?>
<div>
    <label
        for="publish"
        class="cursor-pointer inline-flex items-center gap-2 select-none"
    >
        <x-input-toggle
            id="publish"
            wire:change="publish"
            size="sm"
            :checked="$this->campaign->isPublished()"
            :label="__('Publish')"
        />
    </label>
</div>
