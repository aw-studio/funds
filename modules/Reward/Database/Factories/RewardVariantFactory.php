<?php

namespace Funds\Reward\Database\Factories;

use Funds\Reward\Models\Reward;
use Funds\Reward\Models\RewardVariant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Funds\Rewards\Models\Reward>
 */
class RewardVariantFactory extends Factory
{
    protected $model = RewardVariant::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => 'Variant '.fake()->numberBetween(1, 10),
            'reward_id' => Reward::factory(),
        ];

    }
}
