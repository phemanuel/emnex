<?php

namespace App\Http\Controllers\Platform;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Company;
use App\Models\DocumentSequence;
use App\Models\Order;
use App\Models\Payment;
use App\Models\PaymentMethod;
use App\Models\Role;
use App\Models\Storefront;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CompanyController extends Controller
{
    public function index(
        Request $request
    ): View {

        $search =
            trim(
                (string)
                $request->query(
                    'search'
                )
            );


        $companies =
            Company::query()
                ->when(
                    $search,
                    function ($query) use ($search) {

                        $query->where(
                            function ($query) use ($search) {

                                $query
                                    ->where(
                                        'name',
                                        'like',
                                        '%' .
                                        $search .
                                        '%'
                                    )
                                    ->orWhere(
                                        'id',
                                        $search
                                    );

                            }
                        );

                    }
                )
                ->latest()
                ->paginate(20)
                ->withQueryString();


        $companyIds =
            $companies
                ->pluck('id');


        $storefronts =
            Storefront::query()
                ->whereIn(
                    'company_id',
                    $companyIds
                )
                ->get()
                ->keyBy(
                    'company_id'
                );


        $userCounts =
            User::query()
                ->selectRaw(
                    'company_id, COUNT(*) as total'
                )
                ->whereIn(
                    'company_id',
                    $companyIds
                )
                ->groupBy(
                    'company_id'
                )
                ->pluck(
                    'total',
                    'company_id'
                );


        $branchCounts =
            Branch::query()
                ->selectRaw(
                    'company_id, COUNT(*) as total'
                )
                ->whereIn(
                    'company_id',
                    $companyIds
                )
                ->groupBy(
                    'company_id'
                )
                ->pluck(
                    'total',
                    'company_id'
                );


        return view(
            'platform.companies.index',
            compact(
                'companies',
                'storefronts',
                'userCounts',
                'branchCounts',
                'search'
            )
        );
    }


    public function show(
        Company $company
    ): View {

        $owner =
            User::query()
                ->with('role')
                ->where(
                    'company_id',
                    $company->id
                )
                ->whereHas(
                    'role',
                    function ($query) {

                        $query->where(
                            'code',
                            'owner'
                        );

                    }
                )
                ->first();


        $storefront =
            Storefront::query()
                ->where(
                    'company_id',
                    $company->id
                )
                ->first();


        $headOffice =
            Branch::query()
                ->where(
                    'company_id',
                    $company->id
                )
                ->where(
                    'is_head_office',
                    true
                )
                ->first();


        $stats = [

            'users' =>
                User::query()
                    ->where(
                        'company_id',
                        $company->id
                    )
                    ->count(),

            'branches' =>
                Branch::query()
                    ->where(
                        'company_id',
                        $company->id
                    )
                    ->count(),

            'orders' =>
                Order::query()
                    ->where(
                        'company_id',
                        $company->id
                    )
                    ->count(),

            'online_orders' =>
                Order::query()
                    ->where(
                        'company_id',
                        $company->id
                    )
                    ->where(
                        'sales_channel',
                        'Online'
                    )
                    ->count(),

            'payments' =>
                Payment::query()
                    ->where(
                        'company_id',
                        $company->id
                    )
                    ->count(),

        ];


        $onboarding = [

            'company_created' =>
                true,

            'head_office' =>
                (bool)
                $headOffice,

            'owner_created' =>
                (bool)
                $owner,

            'roles_created' =>
                Role::query()
                    ->where(
                        'company_id',
                        $company->id
                    )
                    ->exists(),

            'payment_methods' =>
                PaymentMethod::query()
                    ->where(
                        'company_id',
                        $company->id
                    )
                    ->exists(),

            'document_sequences' =>
                DocumentSequence::query()
                    ->where(
                        'company_id',
                        $company->id
                    )
                    ->exists(),

            'storefront_enabled' =>
                (bool)
                $storefront,

        ];


        $completedSteps =
            collect(
                $onboarding
            )
            ->filter()
            ->count();


        $totalSteps =
            count(
                $onboarding
            );


        return view(
            'platform.companies.show',
            compact(
                'company',
                'owner',
                'storefront',
                'headOffice',
                'stats',
                'onboarding',
                'completedSteps',
                'totalSteps'
            )
        );
    }
}