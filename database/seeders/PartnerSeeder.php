<?php

namespace Database\Seeders;

use App\Models\Partners\Partner;
use App\Models\User;
use Illuminate\Database\Seeder;

class PartnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Partner::factory(10)->create()->each(function ($partner) {
            $user = User::factory()->make();
            $partner->user()->save($user);
        });
    }
}
