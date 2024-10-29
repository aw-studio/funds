<?php

namespace Funds\Campaign\Database\Factories;

use Funds\Campaign\Models\Faq;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Funds\Campaign\Models\Campaign>
 */
class FaqFactory extends Factory
{
    protected $model = Faq::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'question' => fake()->sentence().'?',
            'answer' => fake()->paragraph(),
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
