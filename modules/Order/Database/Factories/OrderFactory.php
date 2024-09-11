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
            'shipping_address' => fake()->randomElement($this->getAddresses()),
        ];
    }

    protected function getAddresses()
    {
        return [
            [
                'name' => 'John Doe',
                'street' => 'Fleethörn 9',
                'postal_code' => '24103',
                'city' => 'Kiel',
                'country' => 'DEU',
            ],
            [
                'name' => 'Jane Doe',
                'street' => 'New-York-Ring 6',
                'postal_code' => '22297',
                'city' => 'Hamburg',
                'country' => 'DEU',
            ],
            [
                'name' => 'Max Mustermann',
                'street' => 'Kurfürstendamm 195',
                'postal_code' => '10707',
                'city' => 'Berlin',
                'country' => 'DEU',
            ],
            [
                'name' => 'Erika Mustermann',
                'street' => 'Königsallee 60',
                'postal_code' => '40212',
                'city' => 'Düsseldorf',
                'country' => 'DEU',
            ],

        ];
    }
}
