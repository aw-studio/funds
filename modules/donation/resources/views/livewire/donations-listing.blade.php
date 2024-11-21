<?php

use function Livewire\Volt\{state, uses, updated};
use Funds\Donation\Models\Donation;
use Funds\Foundation\Facades\Funds;
use function Livewire\Volt\{with, usesPagination};

state(['search', 'campaign', 'includeRecurring', 'filterReward', 'sortField' => 'created_at', 'sortDirection' => 'DESC', 'perPage' => 10]);
usesPagination();

with(
    fn() => [
        'donations' => $this->campaign
            ->donations()
            ->with('donor', 'reward', 'order')
            ->when($this->includeRecurring == false, fn($query) => $query->where('type', '!=', 'recurring'))
            ->when($this->filterReward, fn($query) => $query->whereHas('order', fn($query) => $query->where('reward_id', $this->filterReward)))
            ->when(strlen($this->search) > 2, fn($query) => $query->search($this->search))
            ->latest()
            ->when($this->sortField, fn($query) => $query->orderBy($this->sortField, $this->sortDirection))
            ->paginate($this->perPage),
    ],
);

$setSort = function ($field) {
    $this->sortField = $field;
    $direction = $this->sortDirection == 'ASC' ? 'DESC' : 'ASC';
    $this->sortDirection = $direction;
};

updated(['perPage' => fn() => $this->resetPage()]);
updated(['search' => fn() => $this->resetPage()]);

?>

<section>
    <div class="flex justify-between items-center mb-4">
        <div class="flex gap-2">
            <x-donation::search-listing />
            <x-select wire:model.live="filterReward">
                <option value="">{{ __('All rewards') }}</option>
                @foreach ($campaign->rewards as $reward)
                    <option
                        value="{{ $reward->id }}"
                        {{ $reward->id == $filterReward ? 'selected' : '' }}
                    >{{ $reward->name }}</option>
                @endforeach
            </x-select>
        </div>
        <div>
            @if (Funds::hasDonationType('recurring'))
                <label
                    for="includeRecurring"
                    class="cursor-pointer inline-flex items-center gap-2 select-none"
                >
                    <x-input-toggle
                        id="includeRecurring"
                        wire:model.live="includeRecurring"
                        size="sm"
                    />
                    {{ __('Include recurring') }}
                </label>
            @endif
            <x-button
                href="{{ route('donations.create', ['campaign' => $campaign]) }}"
                wire:navigate
                outlined
            >
                <x-icons.plus class="mr-2" />
                {{ __('Add Donation') }}
            </x-button>
        </div>

    </div>
    <x-table>
        <x-slot:thead>
            <x-table.th>#</x-table.th>
            <x-table.th>{{ __('Date') }}</x-table.th>
            <x-table.th>{{ __('Donor') }}</x-table.th>
            <x-table.th
                class="cursor-pointer"
                wire:click="setSort('amount')"
            >
                {{ __('Amount') }}

                <span @class([
                    'hidden' => $sortField != 'amount',
                    'transform inline-block' => $sortField == 'amount',
                    'rotate-90' => $sortField == 'amount' && $sortDirection == 'ASC',
                    '-rotate-90' => $sortField == 'amount' && $sortDirection == 'DESC',
                ])>
                    < </span>
            </x-table.th>
            <x-table.th>{{ __('Reward') }}</x-table.th>
            @foreach ($moduleHeaders ?? [] as $header)
                <x-table.th>
                    {{ $header }}
                </x-table.th>
            @endforeach
        </x-slot:thead>
        @foreach ($donations as $donation)
            <x-table.tr
                href="{{ route('donations.show', ['donation' => $donation]) }}"
                wire:key="#{{ $donation->id }}"
            >
                <x-table.td>{{ $donation->id }}</x-table.td>
                <x-table.td>{{ $donation->created_at->isoFormat('L') }}</x-table.td>
                <x-table.td>{{ $donation->donor->name }}</x-table.td>
                <x-table.td>{{ $donation->amount }}</x-table.td>
                <x-table.td>{{ $donation->reward?->name }}</x-table.td>
                @foreach ($moduleColumnsRow ?? [] as $column)
                    <x-table.td>
                        @include($column)
                    </x-table.td>
                @endforeach
            </x-table.tr>
        @endforeach
        @if ($donations->isEmpty())
            <tr>
                <td
                    colspan="100%"
                    class="text-center p-8"
                >
                    {{ __('No donations found.') }}
                </td>
            </tr>
        @endif
    </x-table>

    <div class="flex mt-8 justify-end mb-8">
        {{ $donations->onEachSide(0)->links('donation::components.pagination') }}
    </div>
</section>
