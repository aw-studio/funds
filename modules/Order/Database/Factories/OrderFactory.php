<?php

namespace Funds\Donations\Database\Factories;

use Funds\Campaign\Models\Campaign;
use Funds\Donations\Models\Donation;
use Funds\Donations\Models\Donor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Funds\Donations\Models\Donation>
 */
class OrderFactory extends Factory
{
    protected $model = Donation::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'amount' => fake()->numberBetween(100, 10000),
            'campaign_id' => Campaign::factory(),
            'donor_id' => Donor::factory(),
        ];
    }
}
