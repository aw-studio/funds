<?php

namespace Funds\Order\Database\Factories;

use Funds\Donations\Models\Donation;
use Funds\Order\Models\Order;
use Funds\Reward\Models\Reward;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Funds\Donations\Models\Donation>
 */
class OrderFactory extends Factory
{
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'donation_id' => Donation::factory(),
            'reward_id' => Reward::factory(),
            'shipping_address' => [
                'street' => $this->faker->streetAddress,
                'city' => $this->faker->city,
                'zip' => $this->faker->postcode,
                'country' => $this->faker->country,
            ],
        ];
    }
}
