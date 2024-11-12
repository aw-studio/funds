<?php

use function Livewire\Volt\{state, computed};
use Funds\Foundation\Facades\Funds;
use Funds\Donation\Models\Donation;

state(['campaign']);

$isPublished = computed(function () {
    return $this->campaign->isPublished();
});

$publish = fn() => $this->campaign->isPublished() ? $this->campaign->unpublish() : $this->campaign->publish();

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
            :checked="$this->isPublished"
        />
        {{ __('Publish') }}
    </label>
</div>
