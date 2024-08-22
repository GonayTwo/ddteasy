<?php

namespace Database\Factories\Partners;

use App\Enums\ContactMethods;
use App\Enums\PartnerRoles;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Partners\Partner>
 */
class PartnerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'cpf' => fake()->cpf(false),
            'phone' => fake()->cellphoneNumber(false),
            'consent' => fake()->boolean(),
            'role' => fake()->randomElement(array_column(PartnerRoles::cases(), 'value')),
            'contact_methods' => fake()->randomElements(ContactMethods::cases(), rand(1, 3)),
        ];
    }
}
