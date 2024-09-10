<?php

namespace Database\Seeders;

use App\Models\Admin\Admin;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::create(['phone' => '15992688383'])->each(
            fn ($admin) => User::create([
                'first_name' => 'Squad',
                'last_name' => 'Dev',
                'userable_id' => $admin->id,
                'userable_type' => Admin::class,
                'email' => 'admin@admin.com',
                'password' => Hash::make('P#ssw0rd3'),
                'email_verified_at' => now(),
                'remember_token' => str()->random(10),
            ])
        );
    }
}
