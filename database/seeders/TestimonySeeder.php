<?php

namespace Database\Seeders;

use App\Models\Content\Testimony;
use Illuminate\Database\Seeder;

class TestimonySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Testimony::factory(5)->create();
    }
}
