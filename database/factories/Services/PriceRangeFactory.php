<?php

namespace Database\Factories\Services;

use App\Enums\ApartmentRooms;
use App\Enums\HouseRanges;
use App\Enums\PropertyTypes;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Services\PriceRange>
 */
class PriceRangeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $propertyType = fake()->randomElement(PropertyTypes::cases());

        $propertySize = $propertyType == PropertyTypes::House ? fake()->randomElement(HouseRanges::cases()) : fake()->randomElement(ApartmentRooms::cases());

        return [
            'property_type' => $propertyType,
            'property_size' => $propertySize,
            'min_price' => fake()->numberBetween(15000, 20000),
            'max_price' => fake()->numberBetween(25000, 30000),
        ];
    }
}
