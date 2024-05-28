<?php

namespace Funds\Donations\Database\Factories;

use Funds\Campaign\Models\Campaign;
use Funds\Donations\Models\DonationIntent;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Funds\Donations\Models\DonationIntent>
 */
class DonationIntentFactory extends Factory
{
    protected $model = DonationIntent::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'email' => fake()->safeEmail(),
            'amount' => fake()->numberBetween(100, 10000),
            'campaign_id' => Campaign::factory(),
            // 'rewards' => [],
            'type' => 'donation',
        ];
    }
}
