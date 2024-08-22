<?php

namespace Database\Factories\Contacts;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contacts\Whatsapp>
 */
class WhatsappFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'number' => fake()->cellphoneNumber(),
            'float' => fake()->boolean(),
        ];
    }
}
