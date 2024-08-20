<?php

namespace Database\Factories\Partners;

use App\Enums\ContactMethods;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Partners\PreRegistration>
 */
class PreRegistrationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'company' => fake()->company(),
            'email' => fake()->companyEmail(),
            'phone' => fake()->cellphoneNumber(false),
            'contact_methods' => fake()->randomElements(ContactMethods::cases(), count: rand(1, 3)),
            'finished' => false,
        ];
    }
}
