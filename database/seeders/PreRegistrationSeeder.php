<?php

namespace Database\Seeders;

use App\Models\Partners\PreRegistration;
use Illuminate\Database\Seeder;

class PreRegistrationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PreRegistration::factory(10)->create();
    }
}
