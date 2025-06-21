<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Division;
use App\Models\Company;

class DivisionSeeder extends Seeder
{
    public function run()
    {
        $company = Company::first();

        Division::create([
            'company_id' => $company->id,
            'name' => 'IT'
        ]);

        Division::create([
            'company_id' => $company->id,
            'name' => 'HRD'
        ]);
    }
}
