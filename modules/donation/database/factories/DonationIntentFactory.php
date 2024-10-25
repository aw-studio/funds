<?php

namespace Funds\Donation\Database\Factories;

use Funds\Campaign\Models\Campaign;
use Funds\Donation\Enums\DonationType;
use Funds\Donation\Models\DonationIntent;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Funds\Donation\Models\DonationIntent>
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
            'name' => fake()->name(),
            'amount' => fake()->numberBetween(100, 10000),
            'campaign_id' => Campaign::factory(),
            // 'rewards' => [],
            'type' => DonationType::OneTime->value,
            'pays_fees' => false,
        ];
    }
}
