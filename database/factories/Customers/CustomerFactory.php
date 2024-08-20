<?php

namespace Database\Factories\Customers;

use App\Enums\ContactMethods;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customers\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'pagarme_id' => null,
            'birth_date' => fake()->date(max: 'now -18 years'),
            'cpf' => fake()->cpf(false),
            'phone' => fake()->cellphoneNumber(false),
            'contact_methods' => fake()->randomElements(ContactMethods::cases(), rand(1, 3)),
            'consent' => true,
            'newsletter' => fake()->boolean(15),
        ];
    }
}
