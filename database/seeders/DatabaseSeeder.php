<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([

            // ==============================
            // Company Setup
            // ==============================

            CompanySeeder::class,
            BranchSeeder::class,
            TerminalSeeder::class,

            // ==============================
            // Security
            // ==============================

            RoleSeeder::class,
            PermissionSeeder::class,
            RolePermissionSeeder::class,
            UserSeeder::class,

            // ==============================
            // Configuration
            // ==============================

            SettingSeeder::class,
            DocumentSequenceSeeder::class,

            // ==============================
            // Inventory
            // ==============================

            UnitSeeder::class,
            ProductCategorySeeder::class,
            TaxRateSeeder::class,
            DiscountSeeder::class,
            ProductSeeder::class,
            ProductStockSeeder::class,

            // ==============================
            // Sales
            // ==============================

            CustomerSeeder::class,          

            

        ]);
    }
}
