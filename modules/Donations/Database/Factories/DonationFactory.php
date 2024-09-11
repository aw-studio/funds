<?php

namespace Funds\Donations\Database\Factories;

use Funds\Campaign\Models\Campaign;
use Funds\Donations\Enums\DonationType;
use Funds\Donations\Models\Donation;
use Funds\Donations\Models\Donor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Funds\Donations\Models\Donation>
 */
class DonationFactory extends Factory
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
            'amount' => random_int(10, 100) * 100,
            'campaign_id' => Campaign::factory(),
            'type' => DonationType::OneTime,
            'donor_id' => Donor::factory(),
            'receipt_address' => fake()->randomElement([null, [
                'name' => fake()->name,
                'address' => fake()->address,
                'postal_code' => fake()->postcode,
                'city' => fake()->city,
                'country' => fake()->country,
            ]]),
        ];
    }

    public function withReceiptAddress($address = []): DonationFactory
    {
        return $this->state([
            'receipt_address' => array_merge([
                'name' => fake()->name,
                'address' => fake()->address,
                'postal_code' => fake()->postcode,
                'city' => fake()->city,
                'country' => fake()->country,
            ], $address),
        ]);
    }
}
