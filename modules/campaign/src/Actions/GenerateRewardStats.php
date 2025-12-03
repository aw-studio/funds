<?php

namespace Funds\Campaign\Actions;

use Funds\Campaign\Models\Campaign;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class GenerateRewardStats
{
    public function execute(Campaign $campaign, int $forecastedAmount)
    {

        $totalForecast = $forecastedAmount;

        $rewardStats = Cache::remember("campaign_{$campaign->id}_reward_stats", 60, function () use ($campaign, $totalForecast) {
            $rewardDonations = DB::table('donations')
                ->selectRaw('
                    rewards.id as reward_id,
                    rewards.name as reward_name,
                    COUNT(donations.id) as donation_count,
                    SUM(donations.amount) as total_amount,
                    AVG(donations.amount) as avg_amount
                ')
                ->join('orders', 'orders.donation_id', '=', 'donations.id')
                ->join('rewards', 'orders.reward_id', '=', 'rewards.id')
                ->where('donations.campaign_id', $campaign->id)
                ->groupBy('rewards.id', 'rewards.name')
                ->get();

            $totalDonations = $rewardDonations->sum('donation_count');
            $totalDonated = $campaign->total_donated;

            return $rewardDonations->map(function ($reward) use ($totalDonations, $totalDonated, $totalForecast) {
                $percentage = ($reward->donation_count / $totalDonations) * 100;
                $forecastedAmount = ($reward->donation_count / $totalDonated) * $totalForecast;

                return [
                    'name' => $reward->reward_name,
                    'count' => $reward->donation_count,
                    'sum' => (string) $reward->total_amount,
                    'averageDonationAmount' => (string) $reward->avg_amount,
                    'percentage' => round($percentage, 1),
                    'forecastedAmount' => (int) $forecastedAmount,
                ];
            })->sortByDesc('count');
        });

        return $rewardStats;
    }
}
