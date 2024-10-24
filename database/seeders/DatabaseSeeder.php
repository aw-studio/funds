<?php

namespace Database\Seeders;

use App\Models\User;
use Funds\Campaign\Models\Campaign;
use Funds\Donation\Models\Donation;
use Funds\Reward\Models\Reward;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $campaign = Campaign::factory()->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'user@user.com',
            'current_campaign_id' => $campaign->id,
            'password' => bcrypt('secret'),
        ]);

        Reward::factory()->for($campaign, 'campaign')->count(5)->create();

        foreach ($campaign->rewards as $reward) {
            Donation::factory()->for($campaign, 'campaign')->count(random_int(1, 15))->create();
            Donation::factory()->for($campaign, 'campaign')
                ->has(\Funds\Order\Models\Order::factory([
                    'reward_id' => $reward->id,
                ]))
                ->count(random_int(0, 200))->create();
        }

    }
}
