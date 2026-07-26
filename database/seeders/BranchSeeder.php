<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Company;
use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $company = Company::first();

        if (!$company) {
            $this->command->error('Company not found. Please run CompanySeeder first.');
            return;
        }

        $branches = [

            [
                'branch_code' => 'BR001',
                'name' => 'Head Office',
                'phone' => '08012345678',
                'email' => 'headoffice@emmanexitconsult.com',
                'address' => 'Lagos, Nigeria',
                'is_head_office' => true,
                'status' => true,
            ],

            [
                'branch_code' => 'BR002',
                'name' => 'Lekki Branch',
                'phone' => '08087654321',
                'email' => 'lekki@emmanexitconsult.com',
                'address' => 'Lekki, Lagos',
                'is_head_office' => false,
                'status' => true,
            ],

        ];

        foreach ($branches as $branch) {

            Branch::updateOrCreate(

                [
                    'branch_code' => $branch['branch_code'],
                ],

                [
                    'company_id' => $company->id,
                    'branch_code' => $branch['branch_code'],
                    'name' => $branch['name'],
                    'phone' => $branch['phone'],
                    'email' => $branch['email'],
                    'address' => $branch['address'],
                    'is_head_office' => $branch['is_head_office'],
                    'status' => $branch['status'],
                ]

            );

        }
    }
}