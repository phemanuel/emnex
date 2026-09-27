<?php

namespace App\Services;

use App\Models\Company;
use App\Models\CompanyLifecycleEvent;
use App\Models\DataLifecycleSetting;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CompanyLifecycleService
{
    public function refreshCompany(
        Company $company
    ): Company {

        $settings =
            DataLifecycleSetting::current();


        if (!$settings->enabled) {

            return $company;

        }


        $lastActivity =
            $this->calculateLastActivity(
                $company
            );


        $eligibleAt =
            $lastActivity
                ? $lastActivity
                    ->copy()
                    ->addDays(
                        $settings
                            ->inactivity_days
                    )
                : null;


        $currentStatus =
            $company->lifecycle_status;


        $newStatus =
            $this->determineStatus(
                $company,
                $eligibleAt,
                $settings
            );


        $company->update([

            'last_activity_at' =>
                $lastActivity,

            'archive_eligible_at' =>
                $eligibleAt,

            'lifecycle_status' =>
                $newStatus,

        ]);


        if (
            $currentStatus !==
            $newStatus
        ) {

            CompanyLifecycleEvent::create([

                'company_id' =>
                    $company->id,

                'event' =>
                    'status_changed',

                'from_status' =>
                    $currentStatus,

                'to_status' =>
                    $newStatus,

                'description' =>
                    'Lifecycle status recalculated.',

            ]);

        }


        return $company->fresh();
    }


    public function calculateLastActivity(
        Company $company
    ): ?Carbon {

        $dates = collect([

            $company->created_at,

            $company->updated_at,

        ]);


        $sources = [

            [
                'table' =>
                    'users',

                'column' =>
                    'last_activity_at',
            ],

            [
                'table' =>
                    'users',

                'column' =>
                    'last_login_at',
            ],

            [
                'table' =>
                    'orders',

                'column' =>
                    'created_at',
            ],

            [
                'table' =>
                    'payments',

                'column' =>
                    'created_at',
            ],

            [
                'table' =>
                    'invoices',

                'column' =>
                    'created_at',
            ],

            [
                'table' =>
                    'stock_movements',

                'column' =>
                    'created_at',
            ],

        ];


        foreach ($sources as $source) {

            if (
                !Schema::hasTable(
                    $source['table']
                )
                ||
                !Schema::hasColumn(
                    $source['table'],
                    'company_id'
                )
                ||
                !Schema::hasColumn(
                    $source['table'],
                    $source['column']
                )
            ) {

                continue;

            }


            $date =
                DB::table(
                    $source['table']
                )
                ->where(
                    'company_id',
                    $company->id
                )
                ->max(
                    $source['column']
                );


            if ($date) {

                $dates->push(
                    Carbon::parse(
                        $date
                    )
                );

            }

        }


        return $dates
            ->filter()
            ->map(
                fn ($date) =>
                    $date instanceof Carbon
                        ? $date
                        : Carbon::parse(
                            $date
                        )
            )
            ->sortDesc()
            ->first();
    }


    protected function determineStatus(
        Company $company,
        ?Carbon $eligibleAt,
        DataLifecycleSetting $settings
    ): string {

        /*
         * Do not overwrite states belonging to
         * an active archive operation.
         */

        if (
            in_array(
                $company->lifecycle_status,
                [
                    'Scheduled',
                    'Archiving',
                    'Archive Ready',
                    'Purging',
                    'Archived',
                    'Restoring',
                ],
                true
            )
        ) {

            return
                $company->lifecycle_status;
        }


        if (!$eligibleAt) {

            return 'Active';

        }


        if (
            now()->greaterThanOrEqualTo(
                $eligibleAt
            )
        ) {

            return 'Eligible';

        }


        $monitorFrom =
            $eligibleAt
                ->copy()
                ->subDays(
                    $settings
                        ->grace_period_days
                );


        if (
            now()->greaterThanOrEqualTo(
                $monitorFrom
            )
        ) {

            return 'Monitoring';

        }


        return 'Active';
    }


    public function scanAll(): int
    {
        $count = 0;


        Company::query()
            ->orderBy('id')
            ->chunkById(
                100,
                function ($companies) use (
                    &$count
                ) {

                    foreach (
                        $companies
                        as
                        $company
                    ) {

                        $this->refreshCompany(
                            $company
                        );

                        $count++;

                    }

                }
            );


        return $count;
    }
}