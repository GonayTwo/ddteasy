<?php

namespace Database\Seeders;

use App\Enums\CompanyStatus;
use App\Models\Address;
use App\Models\Partners\Company;
use App\Models\Partners\Partner;
use App\Models\User;
use App\Services\FindCep\FindCepService;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Company::factory(5)->create()->each(function ($company) {
            $company->partners()->save(Partner::inRandomOrder()->limit(1)->get()->first());

            $cep = fake()->randomElement(['18015193', '18078020', '18054050', '18077640', '18087530', '18071052', '18076350', '18047390', '18108500', '18065407', '18044000', '18030130', '18046701', '18105002']);
            $company->address()->save($this->makeAddress($cep));
        });

        $company = Company::factory()->create([
            'corporate_name' => 'Baratoncios LTDA',
            'fantasy_name' => 'Baratoncios',
            'slug' => str('Baratoncios')->slug(),
            'status' => CompanyStatus::Approved,
        ]);
        $company->address()->save($this->makeAddress('18095070'));

        $partner = Partner::factory()->create();
        $user = User::factory()->make(['email' => 'partner@makeweb.com.br']);
        $partner->user()->save($user);

        $company->partners()->save($partner);
    }

    private function makeAddress(?string $cep = null): Address
    {
        $address_data = ['name' => null, 'number' => fake()->numberBetween(100, 1000)];
        $address_data = array_merge($address_data, (array) FindCepService::cep()->get($cep), (array) FindCepService::geolocation()->get($cep)->location);
        unset($address_data['status']);

        return Address::make($address_data);
    }
}
