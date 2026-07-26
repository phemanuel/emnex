<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Company;
use App\Models\Terminal;
use Illuminate\Database\Seeder;

class TerminalSeeder extends Seeder
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

        $branches = Branch::where('company_id', $company->id)->get();

        if ($branches->isEmpty()) {
            $this->command->error('No branches found. Please run BranchSeeder first.');
            return;
        }

        foreach ($branches as $branch) {

            $terminals = [];

            // Every branch gets at least one POS terminal
            $terminals[] = [
                'terminal_code' => $branch->branch_code . '-POS01',
                'terminal_name' => $branch->name . ' POS 1',
                'device_name' => 'Desktop POS',
                'ip_address' => null,
                'status' => true,
            ];

            // Head Office gets an additional terminal
            if ($branch->is_head_office) {

                $terminals[] = [
                    'terminal_code' => $branch->branch_code . '-POS02',
                    'terminal_name' => $branch->name . ' POS 2',
                    'device_name' => 'Desktop POS',
                    'ip_address' => null,
                    'status' => true,
                ];

            }

            foreach ($terminals as $terminal) {

                Terminal::updateOrCreate(

                    [
                        'company_id'    => $company->id,
                        'terminal_code' => $terminal['terminal_code'],
                    ],

                    [
                        'company_id'    => $company->id,
                        'branch_id'     => $branch->id,

                        'terminal_code' => $terminal['terminal_code'],
                        'terminal_name' => $terminal['terminal_name'],

                        'device_name'   => $terminal['device_name'],
                        'ip_address'    => $terminal['ip_address'],

                        'status'        => $terminal['status'],
                    ]

                );

            }

        }
    }
}