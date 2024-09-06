<?php

namespace Funds\Donations\Database\Factories;

use Funds\Donations\Models\Donor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Funds\Donations\Models\Donor>
 */
class DonorFactory extends Factory
{
    protected $model = Donor::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name,
            'email' => fake()->email,
        ];
    }
}
