<?php

namespace App\Services;

use App\Models\Branch;
use App\Models\Company;
use App\Models\DocumentSequence;
use App\Models\PaymentMethod;
use App\Models\Permission;
use App\Models\Role;
use App\Models\Setting;
use App\Models\Terminal;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use RuntimeException;

class CompanyOnboardingService
{
     public function __construct(
        protected StorefrontSetupService $storefrontSetupService,
        protected BusinessProfileService $businessProfileService
    ) {
    }
    /*
    |--------------------------------------------------------------------------
    | Create Company
    |--------------------------------------------------------------------------
    */

    public function create(
        array $companyData,
        array $ownerData,
        bool $addStorefront = false
    ): array
    {
        return DB::transaction(
        function () use (
            $companyData,
            $ownerData,
            $addStorefront
        ) {

            /*
             * -----------------------------------------------------------------
             * Company
             * -----------------------------------------------------------------
             */

            $company = Company::create([
                'company_code' => $this->generateCompanyCode(),

                'name' => $companyData['company_name'],

                'slug' => $this->generateCompanySlug(
                    $companyData['company_name']
                ),

                'email' => $companyData['company_email'] ?? null,

                'phone' => $companyData['company_phone'] ?? null,

                'address' => $companyData['company_address'] ?? null,

                'logo' => null,    
                /*
                 * New companies begin on a 30-day trial.
                 */
                'subscription_start' => now()->toDateString(),

                'subscription_end' => now()
                    ->addDays(30)
                    ->toDateString(),

                'subscription_status' => 'Trial',

                'business_type' => $companyData['business_type'] ?? null,

                'registration_no' => null,

                'tin' => null,

                'status' => true,
            ]);

            /*
            |--------------------------------------------------------------------------
            | Business Profile
            |--------------------------------------------------------------------------
            |
            | Resolve the company's operating profile from the selected business type.
            |
            | The profile is persisted once during onboarding so future changes to the
            | descriptive business_type value do not silently alter company behaviour.
            |
            */

            $this->businessProfileService
                ->initializeForCompany(
                    $company
                );

            /*
             * -----------------------------------------------------------------
             * Head Office
             * -----------------------------------------------------------------
             */

            $headOffice = Branch::create([
                'company_id' => $company->id,

                'branch_code' => $this->generateBranchCode(),

                'name' => 'Head Office',

                'phone' => $companyData['company_phone'] ?? null,

                'email' => $companyData['company_email'] ?? null,

                'address' => $companyData['company_address'] ?? null,

                'is_head_office' => true,

                'status' => true,
            ]);

            /*
             * -----------------------------------------------------------------
             * Initial POS Terminal
             * -----------------------------------------------------------------
             *
             * New companies receive one terminal for the Head Office.
             *
             * Additional terminals can be created later from the
             * Terminal management module.
             */

            $terminal = $this->createInitialTerminal(
                $company,
                $headOffice
            );

            /*
             * -----------------------------------------------------------------
             * Roles
             * -----------------------------------------------------------------
             */

            $roles = $this->createRoles($company);

            /*
             * -----------------------------------------------------------------
             * Permissions
             * -----------------------------------------------------------------
             *
             * Permission definitions come directly from the existing
             * permissions configuration.
             */

            $permissions = $this->createPermissions($company);

            /*
             * -----------------------------------------------------------------
             * Role Permissions
             * -----------------------------------------------------------------
             *
             * Default permissions also come from the existing configuration.
             */

            $this->assignRolePermissions(
                $company,
                $roles,
                $permissions
            );

            /*
             * -----------------------------------------------------------------
             * Owner Role
             * -----------------------------------------------------------------
             */

            $ownerRole = $roles->get('owner');

            if (!$ownerRole) {
                throw new RuntimeException(
                    'The owner role could not be created.'
                );
            }

            /*
             * -----------------------------------------------------------------
             * Company Owner
             * -----------------------------------------------------------------
             */

            $owner = User::create([
                'company_id' => $company->id,

                'branch_id' => $headOffice->id,

                'role_id' => $ownerRole->id,

                'employee_no' => $this->generateEmployeeNumber(
                    $company
                ),

                'first_name' => $ownerData['first_name'],

                'last_name' => $ownerData['last_name'],

                'other_name' => $ownerData['other_name'] ?? null,

                'username' => $ownerData['username'],

                'email' => $ownerData['email'],

                'phone' => $ownerData['phone'] ?? null,

                'password' => Hash::make(
                    $ownerData['password']
                ),

                'status' => true,

                'is_owner' => true,

                'email_verified_at' => now(),

                'employment_date' => now()->toDateString(),

                'force_password_change' => false,

                'password_changed_at' => now(),
            ]);

            /*
             * -----------------------------------------------------------------
             * Company Settings
             * -----------------------------------------------------------------
             */

           $this->createSettings(
                $company,
                $companyData
            );

            /*
             * -----------------------------------------------------------------
             * Document Sequences
             * -----------------------------------------------------------------
             */

            $this->createDocumentSequences($company);

            /*
             * -----------------------------------------------------------------
             * Payment Methods
             * -----------------------------------------------------------------
             */

            $this->createPaymentMethods($company);

            /**
             * -----------------------------------------------------------------
             * Optional Storefront
             * -----------------------------------------------------------------
             */

            $storefront = null;

            if ($addStorefront) {
                $storefront = $this->storefrontSetupService
                    ->createForCompany(
                        $company,
                        $owner
                    );
            }

            /*
             * -----------------------------------------------------------------
             * Result
             * -----------------------------------------------------------------
             */

           return [
                'company' => $company->fresh(),

                'head_office' => $headOffice->fresh(),

                'terminal' => $terminal->fresh(),

                'owner' => $owner->fresh([
                    'role',
                    'branch',
                ]),

                'storefront' => $storefront?->fresh(),
            ];
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Company Code
    |--------------------------------------------------------------------------
    */

    protected function generateCompanyCode(): string
    {
        do {
            $code = 'COMP-' . str_pad(
                (string) random_int(1, 999999),
                6,
                '0',
                STR_PAD_LEFT
            );
        } while (
            Company::withTrashed()
                ->where('company_code', $code)
                ->exists()
        );

        return $code;
    }

    /*
    |--------------------------------------------------------------------------
    | Company Slug
    |--------------------------------------------------------------------------
    */

    protected function generateCompanySlug(string $name): string
    {
        $baseSlug = Str::slug($name);

        if ($baseSlug === '') {
            $baseSlug = 'company';
        }

        $slug = $baseSlug;

        $counter = 1;

        while (
            Company::withTrashed()
                ->where('slug', $slug)
                ->exists()
        ) {
            $counter++;

            $slug = $baseSlug . '-' . $counter;
        }

        return $slug;
    }

    /*
    |--------------------------------------------------------------------------
    | Branch Code
    |--------------------------------------------------------------------------
    */

    protected function generateBranchCode(): string
    {
        do {
            $code = 'BR' . str_pad(
                (string) random_int(1, 999999),
                6,
                '0',
                STR_PAD_LEFT
            );
        } while (
            Branch::withTrashed()
                ->where('branch_code', $code)
                ->exists()
        );

        return $code;
    }

    /*
    |--------------------------------------------------------------------------
    | Employee Number
    |--------------------------------------------------------------------------
    */

    protected function generateEmployeeNumber(Company $company): string
    {
        do {
            $employeeNo = 'EMP' . str_pad(
                (string) random_int(1, 999999),
                6,
                '0',
                STR_PAD_LEFT
            );
        } while (
            User::withTrashed()
                ->where('company_id', $company->id)
                ->where('employee_no', $employeeNo)
                ->exists()
        );

        return $employeeNo;
    }

    /*
    |--------------------------------------------------------------------------
    | Initial Terminal
    |--------------------------------------------------------------------------
    */

    protected function createInitialTerminal(
        Company $company,
        Branch $branch
    ): Terminal {
        return Terminal::create([
            'company_id' => $company->id,

            'branch_id' => $branch->id,

            'terminal_code' => $branch->branch_code . '-POS01',

            'terminal_name' => $branch->name . ' POS 1',

            'device_name' => 'Desktop POS',

            'ip_address' => null,

            'status' => true,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Roles
    |--------------------------------------------------------------------------
    */

    protected function createRoles(Company $company)
    {
        $roles = [
            [
                'name' => 'owner',
                'code' => 'owner',
                'display_name' => 'Owner',
                'description' => 'System owner with unrestricted access.',
            ],
            [
                'name' => 'administrator',
                'code' => 'administrator',
                'display_name' => 'Administrator',
                'description' => 'Company administrator.',
            ],
            [
                'name' => 'branch_manager',
                'code' => 'branch_manager',
                'display_name' => 'Branch Manager',
                'description' => 'Manages a business branch.',
            ],
            [
                'name' => 'supervisor',
                'code' => 'supervisor',
                'display_name' => 'Supervisor',
                'description' => 'Supervises daily business operations.',
            ],
            [
                'name' => 'cashier',
                'code' => 'cashier',
                'display_name' => 'Cashier',
                'description' => 'Processes customer sales.',
            ],
            [
                'name' => 'inventory_manager',
                'code' => 'inventory_manager',
                'display_name' => 'Inventory Manager',
                'description' => 'Manages inventory and stock.',
            ],
            [
                'name' => 'accountant',
                'code' => 'accountant',
                'display_name' => 'Accountant',
                'description' => 'Handles financial operations.',
            ],
        ];

        $createdRoles = collect();

        foreach ($roles as $role) {
            $createdRole = Role::updateOrCreate(
                [
                    'company_id' => $company->id,

                    'name' => $role['name'],
                ],
                [
                    'company_id' => $company->id,

                    'name' => $role['name'],

                    /*
                     * Important:
                     * User::isOwner() and User::hasRole() use this field.
                     */
                    'code' => $role['code'],

                    'display_name' => $role['display_name'],

                    'description' => $role['description'],

                    'status' => true,
                ]
            );

            $createdRoles->put(
                $role['code'],
                $createdRole
            );
        }

        return $createdRoles;
    }

    /*
    |--------------------------------------------------------------------------
    | Permissions
    |--------------------------------------------------------------------------
    */

    protected function createPermissions(Company $company)
    {
        $permissionDefinitions = config(
            'permissions.permissions',
            []
        );

        $permissions = collect();

        foreach ($permissionDefinitions as $module => $actions) {

            foreach ($actions as $action) {

                $code = "{$module}.{$action}";

                $permission = Permission::updateOrCreate(
                    [
                        'company_id' => $company->id,

                        'code' => $code,
                    ],
                    [
                        'company_id' => $company->id,

                        'module' => Str::headline($module),

                        'name' => $code,

                        'display_name' =>
                            Str::headline($action)
                            . ' '
                            . Str::headline($module),

                        'description' =>
                            Str::headline($action)
                            . ' '
                            . Str::headline($module),

                        'status' => true,
                    ]
                );

                $permissions->put(
                    $code,
                    $permission
                );
            }
        }

        return $permissions;
    }

    /*
    |--------------------------------------------------------------------------
    | Assign Role Permissions
    |--------------------------------------------------------------------------
    */

    protected function assignRolePermissions(
        Company $company,
        $roles,
        $permissions
    ): void {
        $defaults = config(
            'permissions.defaults',
            []
        );

        foreach ($defaults as $roleCode => $permissionCodes) {

            $role = $roles->get($roleCode);

            if (!$role) {
                continue;
            }

            $permissionIds = [];

            /*
             * Owner / wildcard access.
             */

            if (in_array('*', $permissionCodes, true)) {

                $permissionIds = $permissions
                    ->pluck('id')
                    ->all();

            } else {

                foreach ($permissionCodes as $permissionCode) {

                    /*
                     * Module wildcard.
                     *
                     * Example:
                     * products.*
                     */

                    if (Str::endsWith(
                        $permissionCode,
                        '.*'
                    )) {

                        $module = Str::beforeLast(
                            $permissionCode,
                            '.*'
                        );

                        $modulePermissionIds = $permissions
                            ->filter(function ($permission) use ($module) {
                                return $permission->module
                                    === Str::headline($module);
                            })
                            ->pluck('id')
                            ->all();

                        $permissionIds = array_merge(
                            $permissionIds,
                            $modulePermissionIds
                        );

                        continue;
                    }

                    /*
                     * Exact permission.
                     */

                    if ($permissions->has($permissionCode)) {

                        $permissionIds[] =
                            $permissions
                                ->get($permissionCode)
                                ->id;
                    }
                }
            }

            $permissionIds = array_values(
                array_unique($permissionIds)
            );

            $syncData = [];

            foreach ($permissionIds as $permissionId) {

                $syncData[$permissionId] = [
                    'company_id' => $company->id,
                ];
            }

            $role->permissions()->sync(
                $syncData
            );
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Settings
    |--------------------------------------------------------------------------
    */
   
    protected function createSettings(
        Company $company,
        array $companyData
    ): Setting {
        $currency = $companyData['currency'] ?? 'NGN';

        $timezone = $companyData['timezone'] ?? 'Africa/Lagos';

        return Setting::updateOrCreate(
            [
                'company_id' => $company->id,
            ],
            [
                'company_name' => $company->name,

                'company_email' => $company->email,

                'company_phone' => $company->phone,

                'company_address' => $company->address,

                'company_logo' => $company->logo,

                'currency' => $currency,

                'currency_symbol' => $this->currencySymbol($currency),

                'tax_rate' => 7.50,

                'tax_enabled' => true,

                'receipt_footer' => 'Thank you for shopping with us.',

                'print_logo' => true,

                'print_barcode' => false,

                'allow_negative_stock' => false,

                'enable_customer_credit' => false,

                'timezone' => $timezone,

                'maintenance_mode' => false,
            ]
        );
    }



    /*
    |--------------------------------------------------------------------------
    | Document Sequences
    |--------------------------------------------------------------------------
    */

    protected function createDocumentSequences(
        Company $company
    ): void {
        $documents = [
            [
                'document_type' => 'category',
                'prefix' => 'CAT',
            ],
            [
                'document_type' => 'product',
                'prefix' => 'PRD',
            ],
            [
                'document_type' => 'customer',
                'prefix' => 'CUS',
            ],
            [
                'document_type' => 'supplier',
                'prefix' => 'SUP',
            ],
            [
                'document_type' => 'order',
                'prefix' => 'ORD',
            ],
            [
                'document_type' => 'payment',
                'prefix' => 'PAY',
            ],
            [
                'document_type' => 'purchase',
                'prefix' => 'PUR',
            ],
            [
                'document_type' => 'purchase_return',
                'prefix' => 'PRN',
            ],
            [
                'document_type' => 'sales_return',
                'prefix' => 'SRN',
            ],
            [
                'document_type' => 'stock_movement',
                'prefix' => 'STM',
            ],
            [
                'document_type' => 'stock_adjustment',
                'prefix' => 'ADJ',
            ],
            [
                'document_type' => 'stock_transfer',
                'prefix' => 'ST',
            ],
            [
                'document_type' => 'stock_count',
                'prefix' => 'SC',
            ],
            [
                'document_type' => 'expense',
                'prefix' => 'EXP',
            ],
            [
                'document_type' => 'unit',
                'prefix' => 'UNT',
            ],
            [
                'document_type' => 'tax',
                'prefix' => 'TAX',
            ],
            [
                'document_type' => 'discount',
                'prefix' => 'DIS',
            ],
            [
                'document_type' => 'goods_received',
                'prefix' => 'GR',
            ],
        ];

        foreach ($documents as $document) {

            DocumentSequence::updateOrCreate(
                [
                    'company_id' => $company->id,

                    'document_type' =>
                        $document['document_type'],
                ],
                [
                    'company_id' => $company->id,

                    'document_type' =>
                        $document['document_type'],

                    'prefix' => $document['prefix'],

                    'suffix' => null,

                    'separator' => '-',

                    'current_number' => 1,

                    'number_length' => 6,

                    'reset_frequency' => 'Never',

                    'status' => true,
                ]
            );
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Payment Methods
    |--------------------------------------------------------------------------
    */

    protected function createPaymentMethods(
        Company $company
    ): void {
        $paymentMethods = [
            [
                'name' => 'Cash',
                'code' => 'CASH',
                'icon' => 'bi-cash',
                'color' => 'success',
                'requires_reference' => false,
                'is_cash' => true,
                'allow_change' => true,
                'display_order' => 1,
            ],
            [
                'name' => 'POS',
                'code' => 'POS',
                'icon' => 'bi-credit-card',
                'color' => 'primary',
                'requires_reference' => true,
                'is_cash' => false,
                'allow_change' => false,
                'display_order' => 2,
            ],
            [
                'name' => 'Transfer',
                'code' => 'TRANSFER',
                'icon' => 'bi-bank',
                'color' => 'info',
                'requires_reference' => true,
                'is_cash' => false,
                'allow_change' => false,
                'display_order' => 3,
            ],
            [
                'name' => 'Wallet',
                'code' => 'WALLET',
                'icon' => 'bi-wallet2',
                'color' => 'warning',
                'requires_reference' => false,
                'is_cash' => false,
                'allow_change' => false,
                'display_order' => 4,
            ],
            [
                'name' => 'Credit',
                'code' => 'CREDIT',
                'icon' => 'bi-person-lines-fill',
                'color' => 'secondary',
                'requires_reference' => false,
                'is_cash' => false,
                'allow_change' => false,
                'display_order' => 5,
            ],
            [
                'name' => 'Cheque',
                'code' => 'CHEQUE',
                'icon' => 'bi-receipt',
                'color' => 'dark',
                'requires_reference' => true,
                'is_cash' => false,
                'allow_change' => false,
                'display_order' => 6,
            ],
        ];

        foreach ($paymentMethods as $method) {

            PaymentMethod::updateOrCreate(
                [
                    'company_id' => $company->id,

                    'code' => $method['code'],
                ],
                [
                    'company_id' => $company->id,

                    ...$method,

                    'status' => true,
                ]
            );
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Currency Symbol
    |--------------------------------------------------------------------------
    */

    protected function currencySymbol(
        string $currency
    ): string {
        return match (strtoupper($currency)) {
            'NGN' => '₦',
            'USD' => '$',
            'GBP' => '£',
            'EUR' => '€',
            default => strtoupper($currency),
        };
    }
}

