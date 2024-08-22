<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Address>
 */
class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => null,
            'cep' => null,
            'street' => null,
            'number' => null,
            'complement' => null,
            'district' => null,
            'city' => null,
            'state' => null,
            'country' => 'BR',
            'lat' => null,
            'lon' => null,
        ];
    }
}
