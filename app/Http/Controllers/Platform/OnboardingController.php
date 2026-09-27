<?php

namespace App\Http\Controllers\Platform;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Company;
use App\Models\PaymentMethod;
use App\Models\Role;
use App\Models\Storefront;
use App\Models\User;
use Illuminate\View\View;

class OnboardingController extends Controller
{
    public function index(): View
    {
        $companies =
            Company::query()
                ->latest()
                ->paginate(25);


        $rows =
            $companies
                ->getCollection()
                ->map(
                    function (
                        Company $company
                    ) {

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
                                ->exists();


                        $owner =
                            User::query()
                                ->where(
                                    'company_id',
                                    $company->id
                                )
                                ->whereHas(
                                    'role',
                                    fn ($query) =>
                                        $query->where(
                                            'code',
                                            'owner'
                                        )
                                )
                                ->exists();


                        $roles =
                            Role::query()
                                ->where(
                                    'company_id',
                                    $company->id
                                )
                                ->exists();


                        $paymentMethods =
                            PaymentMethod::query()
                                ->where(
                                    'company_id',
                                    $company->id
                                )
                                ->exists();


                        $storefront =
                            Storefront::query()
                                ->where(
                                    'company_id',
                                    $company->id
                                )
                                ->first();


                        $steps = [

                            $headOffice,
                            $owner,
                            $roles,
                            $paymentMethods,

                        ];


                        return [

                            'company' =>
                                $company,

                            'completed' =>
                                collect(
                                    $steps
                                )
                                ->filter()
                                ->count(),

                            'total' =>
                                count(
                                    $steps
                                ),

                            'storefront' =>
                                $storefront,

                        ];

                    }
                );


        return view(
            'platform.onboarding.index',
            compact(
                'companies',
                'rows'
            )
        );
    }
}