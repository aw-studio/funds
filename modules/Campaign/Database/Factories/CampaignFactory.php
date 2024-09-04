<?php

namespace Funds\Campaign\Database\Factories;

use Funds\Campaign\Models\Campaign;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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
            'slug' => fn ($attributes) => Str::slug($attributes['name']),
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            'goal' => random_int(1, 25) * 1000 * 100,
            'fees' => random_int(1, 5),
            'content' => fake()->paragraphs(10, true),
            'start_date' => fake()->dateTimeBetween('-1 month', 'now'),
            'end_date' => fake()->dateTimeBetween('now', '+1 month'),
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
