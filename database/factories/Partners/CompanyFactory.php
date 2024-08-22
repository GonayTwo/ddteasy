<?php

namespace Database\Factories\Partners;

use App\Enums\CompanyStatus;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\File;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Partners\Company>
 */
class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        if (!File::isDirectory(storage_path('app/public/companies/images'))) {
            File::makeDirectory(storage_path('app/public/companies/images'), 0777, true, true);
        }

        $fantasy_name = fake()->company();
        $corporate_name = $fantasy_name . ' LTDA';

        return [
            'corporate_name' => $corporate_name,
            'fantasy_name' => $fantasy_name,
            'cnpj' => fake()->cnpj(false),
            'social_contract' => \Illuminate\Http\UploadedFile::fake()->create('test.pdf')->store('/companies/documents', 'public'),
            'sanitary_license' => \Illuminate\Http\UploadedFile::fake()->create('test.pdf')->store('/companies/documents', 'public'),
            'logo' => 'companies/images/' . fake()->image(dir: storage_path('app/public/companies/images'), width: 500, height: 500, fullPath: false, category: $fantasy_name),
            'status' => fake()->randomElement(CompanyStatus::cases()),
            'slug' => str()->slug($corporate_name),
        ];
    }
}
