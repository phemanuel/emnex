<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class UpdateRoleCodesSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [

            'owner',
            'administrator',
            'branch_manager',
            'supervisor',
            'cashier',
            'inventory_manager',
            'accountant',

        ];


        foreach ($roles as $role) {

            Role::where('name', $role)
                ->update([
                    'code' => $role,
                ]);

        }
    }
}