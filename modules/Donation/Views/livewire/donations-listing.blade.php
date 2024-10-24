<?php

use function Livewire\Volt\{state};
use Funds\Foundation\Facades\Funds;
use Funds\Donation\Models\Donation;
use function Livewire\Volt\{with, usesPagination};

state(['search', 'campaign', 'includeRecurring', 'filterReward']);
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
            ->paginate(10),
    ],
);

?>

<section>
    <div class="flex justify-between items-center mb-4">
        <div class="flex gap-2">
            <x-donations::search-listing />
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
        </div>

    </div>
    <x-table>
        <x-slot:thead>
            <x-table.th>#</x-table.th>
            <x-table.th>{{ __('Date') }}</x-table.th>
            <x-table.th>{{ __('Donor') }}</x-table.th>
            <x-table.th>{{ __('Amount') }}</x-table.th>
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

    <div class="mt-8">
        {{ $donations->onEachSide(0)->links('donations::components.pagination') }}
    </div>
</section>
