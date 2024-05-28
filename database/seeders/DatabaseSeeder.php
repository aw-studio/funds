<?php

namespace Database\Seeders;

use App\Models\User;
use Funds\Campaign\Models\Campaign;
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
        // User::factory(10)->create();

        $camapgin = Campaign::factory()->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'user@user.com',
            'current_campaign_id' => $camapgin->id,
            'password' => bcrypt('secret'),
        ]);

        Reward::factory()->for($camapgin, 'campaign')->count(3)->create();
    }
}
