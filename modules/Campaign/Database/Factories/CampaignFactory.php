<?php

namespace Funds\Campaign\Database\Factories;

use Funds\Campaign\Models\Campaign;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Funds\Campaign\Models\Campaign>
 */
class CampaignFactory extends Factory
{
    protected $model = Campaign::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->randomElement($this->names()),
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            'goal' => random_int(1, 100) * 1000 * 100,
        ];
    }

    protected function names(): array
    {
        return [
            'Helping Hands',
            'Stop Hunger',
            'Save the Planet',
            'Clean Water',
            'Education for All',
            'Support the Arts',
            'Animal Rescue',
        ];
    }
}
