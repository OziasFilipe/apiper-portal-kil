<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Company;

class CompanySeeder extends Seeder
{
    public function run(): void
    {
        Company::create([
            'name' => 'Epiper Tecnologia',
            'trade_name' => 'Epiper',
            'document' => '00.000.000/0001-00',
            'email' => 'contato@epiper.com.br',
            'phone' => '(00) 0000-0000',
            'address' => 'Rua Exemplo, 123',
            'city' => 'São Paulo',
            'state' => 'SP',
            'zip_code' => '00000-000',
            'status' => true,
        ]);
    }
}