<?php

namespace Funds\Order\Database\Factories;

use Funds\Donation\Models\Donation;
use Funds\Order\Models\Order;
use Funds\Reward\Models\Reward;
use Illuminate\Database\Eloquent\Factories\Factory;
use Symfony\Component\Intl\Countries;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Funds\Donation\Models\Donation>
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
                'country' => Countries::getAlpha2Code('DEU'),
            ],
            [
                'name' => 'Jane Doe',
                'street' => 'New-York-Ring 6',
                'postal_code' => '22297',
                'city' => 'Hamburg',
                'country' => Countries::getAlpha2Code('DEU'),
            ],
            [
                'name' => 'Max Mustermann',
                'street' => 'Kurfürstendamm 195',
                'postal_code' => '10707',
                'city' => 'Berlin',
                'country' => Countries::getAlpha2Code('DEU'),
            ],
            [
                'name' => 'Erika Mustermann',
                'street' => 'Königsallee 60',
                'postal_code' => '40212',
                'city' => 'Düsseldorf',
                'country' => Countries::getAlpha2Code('DEU'),
            ],

        ];
    }
}
