<?php

namespace Database\Seeders;

use App\Models\Contacts\Whatsapp;
use Illuminate\Database\Seeder;

class WhatsappSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Whatsapp::factory()->create();
    }
}
