<?php

namespace Database\Seeders;

use App\Models\Admin\Admin;
use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::create(['phone' => '15992688383'])->each(
            fn ($admin) => User::create([
                'first_name' => 'Agência',
                'last_name' => 'Makeweb',
                'userable_id' => $admin->id,
                'userable_type' => Admin::class,
                'email' => 'admin@makeweb.com.br',
                'password' => '$2y$10$tQ.eaqIw2D8X7N.D3f2M5.0tZ.Pf29eAua2FT/TuFsAyb/D5LuF8q',
                'email_verified_at' => now(),
                'remember_token' => str()->random(10),
            ])
        );
    }
}
