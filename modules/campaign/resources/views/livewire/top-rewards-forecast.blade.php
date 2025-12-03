<?php
use Funds\Campaign\Models\Campaign;
use Funds\Foundation\Support\Amount;
use Funds\Campaign\Actions\GenerateRewardStats;
use function Livewire\Volt\{state, computed, mount};

state([
    'forecastAmount' => 0,
    'campaign',
    'showForecast' => false,
    'showAllRewards' => false,
]);

mount(function ($campaign) {
    $this->forecastAmount = $this->calculateForecastAmount();
});

$calculateForecastAmount = function () {
    return ceil($this->campaign->goal->get() / 100 / 50000) * 50000;
};

$rewardOrders = computed(function () {
    $totalForecast = intval($this->forecastAmount) * 100;
    $action = new GenerateRewardStats();
    $allRewards = $action->execute(Campaign::find($this->campaign->id), $totalForecast);

    if ($this->showAllRewards) {
        return $allRewards;
    }

    return $allRewards->take(7);
});

$toggleForecast = function () {
    $this->showForecast = !$this->showForecast;
};

$toggleShowAllRewards = function () {
    $this->showAllRewards = !$this->showAllRewards;
};

?>
<div>
    @if ($this->rewardOrders->isEmpty())
        <div class="text-center mt-4">
            {{ __('No rewards have been ordered yet.') }}
        </div>
    @else
        <ul>
            @foreach ($this->rewardOrders as $rewardName => $reward)
                <li class="flex justify-between py-4 border-b">
                    <span title="{{ $reward['sum'] }}">
                        {{ $reward['name'] }}
                    </span>
                    <div>
                        <span title="{{ __('Ordered Quantity') }}">{{ $reward['count'] }}
                            @if (!$showForecast)
                                ({{ $reward['percentage'] }}%)
                            @endif
                        </span>

                        @if ($showForecast)
                            / <span
                                title="{{ __('Forecasted Quantity at :forecastedTotal', ['forecastedTotal' => new Amount($forecastAmount * 100)]) }}"
                            >
                                {{ $reward['forecastedAmount'] }}
                            </span>
                        @endif
                        </span>
                    </div>
                </li>
            @endforeach
        </ul>
        <div class="flex gap-4 mt-4 justify-between">
            <x-button
                round
                outlined
                wire:click="toggleForecast"
                iconButton
                class="w-10 h-10 "
            >
                <x-icons.calculator class=" w-4 h-4" />
            </x-button>
            @if ($showForecast)
                <x-input
                    type="text"
                    wire:model.live.debounce.200ms="forecastAmount"
                >
                    <x-slot name="prefix">
                        <span class="mb-0.5">€</span>
                    </x-slot>
                </x-input>
            @endif
            @if ($this->rewardOrders->count() >= 7)
                <x-button
                    round
                    outlined
                    wire:click="toggleShowAllRewards"
                    iconButton
                    class="w-10 h-10"
                    title="@if (!$showAllRewards)Alle anzeigen @else Ausblenden @endif"
                >
                    @if (!$showAllRewards)
                        <x-icons.arrow-down class="w-4 h-4" />
                    @else
                        <x-icons.arrow-up class="w-4 h-4" />
                    @endif
                </x-button>
            @endif
        </div>
    @endif
</div>
