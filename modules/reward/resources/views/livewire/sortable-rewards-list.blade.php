<?php
use Funds\Reward\Models\Reward;
use function Livewire\Volt\{state, computed};

state(['rewards']);

$sortedRewards = computed(function () {
    return $this->rewards->where('is_active', true)->sortBy('order');
});

$updateRewardsOrder = function ($newOrder) {
    $updates = [];
    foreach ($newOrder as $item) {
        $reward = $this->rewards->find($item['value']);
        if ($reward) {
            $reward->loadCount('variants');
        } else {
            continue;
        }

        if ($reward->order == $item['order']) {
            continue;
        }

        $updates[] = ['id' => $reward->id, 'order' => $item['order']];
    }

    foreach ($updates as $update) {
        $this->rewards->find($update['id'])->update(['order' => $update['order']]);
    }
};
?>
<ul
    wire:sortable="updateRewardsOrder"
    class="col-span-full grid grid-cols-3 gap-4"
>
    @foreach ($this->sortedRewards as $reward)
        <li
            wire:sortable.item="{{ $reward->id }}"
            wire:key="reward-{{ $reward->id }}"
        >
            <x-rewards::reward-item :$reward />
        </li>
    @endforeach
</ul>
