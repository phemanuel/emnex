<?php

namespace App\Console\Commands;

use App\Models\Company;
use App\Services\BusinessProfileService;
use Illuminate\Console\Command;

class BackfillCompanyBusinessProfiles extends Command
{
    /*
    |--------------------------------------------------------------------------
    | Command
    |--------------------------------------------------------------------------
    */

    protected $signature =
        'emnex:backfill-business-profiles';


    /*
    |--------------------------------------------------------------------------
    | Description
    |--------------------------------------------------------------------------
    */

    protected $description =
        'Create missing business profile records for existing companies.';


    /*
    |--------------------------------------------------------------------------
    | Execute
    |--------------------------------------------------------------------------
    */

    public function handle(
        BusinessProfileService $businessProfileService
    ): int {

        $created = 0;

        $skipped = 0;


        Company::query()
            ->orderBy('id')
            ->chunkById(
                100,
                function ($companies) use (
                    $businessProfileService,
                    &$created,
                    &$skipped
                ) {

                    foreach ($companies as $company) {

                        /*
                        |--------------------------------------------------------------------------
                        | Existing Profile
                        |--------------------------------------------------------------------------
                        |
                        | Never overwrite an existing company's operating profile.
                        |
                        */

                        if (
                            $company
                                ->businessProfile()
                                ->exists()
                        ) {

                            $skipped++;

                            continue;
                        }


                        /*
                        |--------------------------------------------------------------------------
                        | Initialize Profile
                        |--------------------------------------------------------------------------
                        */

                        $businessProfile =
                            $businessProfileService
                                ->initializeForCompany(
                                    $company
                                );


                        $created++;


                        $this->line(
                            sprintf(
                                '%s → %s',
                                $company->name,
                                $businessProfile->profile_key
                            )
                        );
                    }
                }
            );


        /*
        |--------------------------------------------------------------------------
        | Summary
        |--------------------------------------------------------------------------
        */

        $this->newLine();

        $this->info(
            "Created: {$created}"
        );

        $this->info(
            "Already configured: {$skipped}"
        );


        return self::SUCCESS;
    }
}