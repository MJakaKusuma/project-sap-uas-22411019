<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Company;

class CompanySeeder extends Seeder
{
    public function run()
    {
        Company::create(['name' => 'PT. Contoh Perusahaan', 'email' => 'company@example,com', 'phonenumber' => '084131331131', 'address' => 'Lampung']);
        Company::create(['name' => 'PT. Contoh Lain', 'email' => 'company@example,com', 'phonenumber' => '084131331131', 'address' => 'Lampung']);
    }
}
