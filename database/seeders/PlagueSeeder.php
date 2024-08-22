<?php

namespace Database\Seeders;

use App\Models\Services\Plague;
use Illuminate\Database\Seeder;

class PlagueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Plague::create(['name' => 'Baratas',      'slug' => 'baratas']);
        Plague::create(['name' => 'Carrapatos',   'slug' => 'carrapatos']);
        Plague::create(['name' => 'Cupins',       'slug' => 'cupins']);
        Plague::create(['name' => 'Escorpiões',   'slug' => 'escorpioes']);
        Plague::create(['name' => 'Formigas',     'slug' => 'formigas']);
        Plague::create(['name' => 'Moscas',       'slug' => 'moscas']);
        Plague::create(['name' => 'Mosquitos',    'slug' => 'mosquitos']);
        Plague::create(['name' => 'Percevejos',   'slug' => 'percevejos']);
        Plague::create(['name' => 'Pombos',       'slug' => 'pombos']);
        Plague::create(['name' => 'Pulgas',       'slug' => 'pulgas']);
        Plague::create(['name' => 'Ratos',        'slug' => 'ratos']);
        Plague::create(['name' => 'Traças',       'slug' => 'tracas']);
    }
}
