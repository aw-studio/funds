<?php

use function Livewire\Volt\{state};
use Funds\Donations\Models\Donation;
use function Livewire\Volt\{with, usesPagination};

usesPagination();

state(['donations']);

$delete = function ($id) {
    $donation = Donation::with('donor')->find($id);
    $donation->delete();
};

?>

<section>
    @if ($donations->isEmpty())
        <p>No donations found.</p>
    @endif
    @foreach ($donations as $donation)
        <table class="w-full">
            <tr>
                <td>{{ $donation->id }}</td>
                <td>{{ $donation->created_at->isoFormat('L') }}</td>
                <td>{{ $donation->donor->email }}</td>
                <td>{{ $donation->amount->format() }}</td>
                <td>
                    <button wire:click="delete({{ $donation->id }})">Delete</button>
                </td>
            </tr>
        </table>
    @endforeach
</section>
