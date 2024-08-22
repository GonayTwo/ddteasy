<?php

namespace Database\Seeders;

use App\Enums\ApartmentRooms;
use App\Enums\PropertyTypes;
use App\Models\Services\PriceRange;
use App\Models\Services\Service;
use Illuminate\Database\Seeder;

class PriceRangeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $service = Service::first();

        $priceRanges = [];

        foreach (ApartmentRooms::cases() as $roomsQuantity) {
            $priceRanges[] = PriceRange::factory()->make([
                'property_type' => PropertyTypes::Apartament,
                'property_size' => $roomsQuantity,
            ]);
        }

        $service->priceRanges()->saveMany($priceRanges);
    }
}
