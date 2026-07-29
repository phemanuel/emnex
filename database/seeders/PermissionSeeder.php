<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (Company::all() as $company) {

            foreach (config('permissions.permissions') as $module => $actions) {

                foreach ($actions as $action) {

                    $code = "{$module}.{$action}";

                    Permission::updateOrCreate(

                        [
                            'company_id' => $company->id,
                            'code'       => $code,
                        ],

                        [
                            'module'       => Str::headline($module),
                            'name'         => $code,
                            'display_name' => Str::headline($action) . ' ' . Str::headline($module),
                            'description'  => Str::headline($action) . ' ' . Str::headline($module),
                            'status'       => true,
                            'is_system'    => true,
                        ]

                    );

                }

            }

        }
    }
}