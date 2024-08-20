<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            QuestionSeeder::class,
            PlagueSeeder::class,
            ServiceSeeder::class,
            AdminSeeder::class,
            TermsOfUseSeeder::class,
            PrivacyPolicySeeder::class,
        ]);
    }
}