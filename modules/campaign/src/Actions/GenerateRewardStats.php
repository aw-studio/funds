<?php

namespace Funds\Campaign\Actions;

use Funds\Campaign\Models\Campaign;

class GenerateRewardStats
{
    public function execute(Campaign $campaign, int $forecastedAmount)
    {

        $totalForecast = $forecastedAmount;

        $rewardDonations = $campaign
            ->donations()
            ->whereHas('order')
            ->with('order.reward')
            ->get();

        return $rewardDonations
            ->groupBy(function ($donation) {
                return $donation->order->reward->id;
            })
            ->map(function ($donations) use ($rewardDonations, $totalForecast) {
                $count = $donations->count();
                $percentage = ($count / $rewardDonations->count()) * 100;
                $sum = $forecastedAmount = ($count / $rewardDonations->totalAmount()->get()) * $totalForecast;

                return [
                    'name' => $donations->first()->order->reward->name,
                    'count' => $count,
                    'sum' => (string) $donations->totalAmount(),
                    'averageDonationAmount' => (string) $donations->averageAmount(),
                    'percentage' => round($percentage, 1),
                    'forecastedAmount' => (int) $forecastedAmount,
                ];
            })
            ->sortByDesc('count');
    }
}
