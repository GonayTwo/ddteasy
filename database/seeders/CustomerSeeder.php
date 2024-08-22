<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Customers\Customer;
use App\Models\User;
use App\Services\FindCep\FindCepService;
use App\Services\Pagarme\PagarmeService;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Customer::factory(1)->create()->each(function ($customer) {
            $customer->user()->save(User::factory()->make(['email' => 'customer@makeweb.com.br', 'password' => bcrypt('password')]));

            $cep = '18095070';
            $address_data = array_merge(['name' => null, 'number' => 304], (array) FindCepService::cep()->get($cep), (array) FindCepService::geolocation()->get($cep)->location);
            unset($address_data['status']);

            $customer->address()->save(Address::factory($address_data)->make());

            try {
                $pagarme_service = new PagarmeService();
                $pagarme_customer = $pagarme_service->customers()->create([
                    'name' => "{$customer->user->first_name} {$customer->user->last_name}",
                    'email' => $customer->user->email,
                    'document' => $customer->cpf,
                    'document_type' => 'CPF',
                    'type' => 'individual',
                    'code' => $customer->id,
                    'birthdate' => $customer->birth_date,
                    'phones' => [
                        'mobile_phone' => [
                            'country_code' => '55',
                            'area_code' => substr($customer->phone, 0, 2),
                            'number' => substr($customer->phone, 2),
                        ],
                    ],
                ]);

                $customer->pagarme_id = $pagarme_customer->id;
                $customer->save();
            } catch (\Exception $e) {
                throw new \Exception('user cannot be created', 409);
            }
        });
    }
}
