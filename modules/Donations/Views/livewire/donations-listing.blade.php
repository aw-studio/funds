<?php

use function Livewire\Volt\{state};
use Funds\Donations\Models\Donation;
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
            ->search($this->search)
            ->paginate(10),
    ],
);

$delete = function ($id) {
    $donation = Donation::with('donor')->find($id);
    $donation->delete();
};

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
            @if (\Funds\Core\Facades\Funds::hasDonationType('recurring'))
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
    <div
        class="overflow-x-auto
                    rounded-lg
                    border
                    border-gray-200">
        <table class="min-w-full divide-y-2 divide-gray-200 bg-white m">
            <thead>
                <tr>
                    <th class="whitespace-nowrap text-left px-4 py-2 font-medium">#</th>
                    <th class="whitespace-nowrap text-left px-4 py-2 font-medium">
                        {{ __('Date') }}
                    </th>
                    <th class="whitespace-nowrap text-left px-4 py-2 font-medium">
                        {{ __('Donor') }}
                    </th>
                    <th class="whitespace-nowrap text-left px-4 py-2 font-medium">
                        {{ __('Amount') }}
                    </th>
                    <th class="whitespace-nowrap text-left px-4 py-2 font-medium">
                        {{ __('Reward') }}
                    </th>
                    @foreach ($moduleHeaders ?? [] as $header)
                        <th class="whitespace-nowrap text-left px-4 py-2 font-medium">
                            {{ $header }}
                        </th>
                    @endforeach
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-200">
                @foreach ($donations as $donation)
                    <tr>
                        <td class="whitespace-nowrap px-4 py-2 font-medium">
                            <a href="{{ route('donations.show', $donation) }}">
                                {{ $donation->id }}
                            </a>
                        </td>
                        </td>
                        <td class="whitespace-nowrap px-4 py-2">
                            <a href="{{ route('donations.show', $donation) }}">
                                {{ $donation->created_at->isoFormat('L') }}
                            </a>
                        </td>
                        <td class="whitespace-nowrap px-4 py-2">
                            {{ $donation->donor->email }}
                        </td>
                        <td class="whitespace-nowrap px-4 py-2">
                            {{ $donation->amount->format() }}
                        </td>
                        <td class="whitespace-nowrap px-4 py-2">
                            {{ $donation->reward?->name }}
                        </td>
                        @foreach ($moduleColumnsRow ?? [] as $column)
                            <td class="whitespace-nowrap px-4 py-2">
                                @include($column)
                            </td>
                        @endforeach
                    </tr>
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
            </tbody>
        </table>
    </div>

    {{ $donations->links() }}
</section>
