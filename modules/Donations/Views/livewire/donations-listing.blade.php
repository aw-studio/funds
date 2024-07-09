<?php

use function Livewire\Volt\{state};
use Funds\Donations\Models\Donation;
use function Livewire\Volt\{with, usesPagination};

usesPagination();

with(
    fn() => [
        'donations' => Donation::with('donor', 'reward', 'order')
            ->when(!request()->has('recurring'), fn($query, $search) => $query->where('type', '!=', 'recurring'))
            ->paginate(10),
    ],
);

$delete = function ($id) {
    $donation = Donation::with('donor')->find($id);
    $donation->delete();
};

?>

<section>
    @if ($donations->isEmpty())
        <p>{{ __('No donations found.') }}</p>
    @else
        <table class="w-full">
            <thead>
                <th class="text-left">#</th>
                <th class="text-left">{{ __('Date') }}</th>
                <th class="text-left">{{ __('Donor') }}</th>
                <th class="text-left">{{ __('Amount') }}</th>
                <th class="text-left">{{ __('Reward') }}</th>
                <th class="text-left">{{ __('Shipment') }}</th>
                <th class="text-left">{{ __('Actions') }}</th>
            </thead>
            @foreach ($donations as $donation)
                <tr>
                    <td>
                        <a href="{{ route('donations.show', $donation) }}">
                            {{ $donation->id }}
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('donations.show', $donation) }}">
                            {{ $donation->created_at->isoFormat('L') }}
                        </a>
                    </td>
                    <td>
                        {{ $donation->donor->email }}
                    </td>
                    <td>{{ $donation->amount->format() }}</td>
                    <td>
                        {{ $donation->reward?->name }}
                    </td>
                    <td>
                        {{ $donation->order?->status ?? __(' -') }}
                    </td>
                    <td>
                        <button wire:click="delete({{ $donation->id }})">Delete</button>
                    </td>
                </tr>
            @endforeach

        </table>
        {{ $donations->links() }}
    @endif
</section>
