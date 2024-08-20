<?php

namespace Database\Factories\Content;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\File;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Content\Testimony>
 */
class TestimonyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        if (!File::isDirectory(storage_path('app/public/testimonies'))) {
            File::makeDirectory(storage_path('app/public/testimonies'), 0777, true, true);
        }

        return [
            'name' => fake()->name(),
            'testimony' => fake()->realText(255),
            'image' => 'testimonies/' . fake()->image(dir: storage_path('app/public/testimonies'), width: 500, height: 500, fullPath: false, category: 'person'),
            'sort' => fake()->randomNumber(1),
        ];
    }
}
