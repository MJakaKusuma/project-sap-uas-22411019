<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Company;
use App\Models\Division;

class UserSeeder extends Seeder
{
    public function run()
    {
        $company = Company::first();
        $division = Division::first();

        // Superadmin tanpa company dan division
        User::create([
            'name' => 'Jaka Kusuma',
            'email' => 'superadmin@example.com',
            'password' => Hash::make('123456'),
            'role' => 'superadmin',
            'company_id' => null,
            'division_id' => null,
        ]);

        // Admin perusahaan
        User::create([
            'name' => 'Admin Perusahaan',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'company_id' => $company->id,
            'division_id' => null,
        ]);

        // Manager di divisi IT
        User::create([
            'name' => 'Manager IT',
            'email' => 'manager@example.com',
            'password' => Hash::make('password'),
            'role' => 'manager',
            'company_id' => $company->id,
            'division_id' => $division->id,
        ]);

        // Employee di divisi IT
        User::create([
            'name' => 'Karyawan IT',
            'email' => 'employee@example.com',
            'password' => Hash::make('password'),
            'role' => 'employee',
            'company_id' => $company->id,
            'division_id' => $division->id,
        ]);
    }
}
