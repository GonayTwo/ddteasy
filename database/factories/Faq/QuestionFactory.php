<?php

namespace Database\Factories\Faq;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Faq\Question>
 */
class QuestionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->realTextBetween(15, 50),
            'text' => fake()->realText(),
            'sort' => fake()->numberBetween(0, 10),
        ];
    }
}
