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

        Reward::factory()->for($campaign, 'campaign')->count(2)->create();
        Reward::factory()->for($campaign, 'campaign')
            ->has(\Funds\Reward\Models\RewardVariant::factory()->count(2), 'variants')->count(2)->create();

        foreach ($campaign->rewards()->with('variants')->get() as $reward) {
            Donation::factory()->for($campaign, 'campaign')->count(random_int(1, 15))->create();
            Donation::factory()->for($campaign, 'campaign')
                ->has(\Funds\Order\Models\Order::factory([
                    'reward_id' => $reward->id,
                    'reward_variant_id' => $reward->variants->count() > 0 ? $reward->variants->random()->id : null,
                    'campaign_id' => $campaign->id,
                ]))
                ->count(random_int(0, 200))->create();
        }

    }
}
