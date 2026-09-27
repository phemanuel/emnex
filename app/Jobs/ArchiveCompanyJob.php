<?php

namespace App\Jobs;

use App\Models\Company;
use App\Models\CompanyArchive;
use App\Models\CompanyLifecycleEvent;
use App\Services\CompanyArchiveService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Throwable;

class ArchiveCompanyJob implements ShouldQueue
{
    use Queueable;


    public function __construct(
        public int $archiveId
    ) {
    }


    public function handle(
        CompanyArchiveService $service
    ): void {

        $archive =
            CompanyArchive::query()
                ->findOrFail(
                    $this->archiveId
                );


        $company =
            Company::query()
                ->findOrFail(
                    $archive
                        ->original_company_id
                );


        $archive->update([

            'status' =>
                'Processing',

            'started_at' =>
                now(),

            'error_message' =>
                null,

        ]);


        $company->update([

            'lifecycle_status' =>
                'Archiving',

            'lifecycle_locked' =>
                true,

        ]);


        try {

            $service->build(
                $archive
            );


            $verified =
                $service->verify(
                    $archive->fresh()
                );


            if (!$verified) {

                throw new \RuntimeException(
                    'Archive verification failed.'
                );

            }


            $company->update([

                'lifecycle_status' =>
                    'Archive Ready',

                'lifecycle_locked' =>
                    false,

            ]);


            CompanyLifecycleEvent::create([

                'company_id' =>
                    $company->id,

                'archive_id' =>
                    $archive->id,

                'event' =>
                    'archive_verified',

                'from_status' =>
                    'Archiving',

                'to_status' =>
                    'Archive Ready',

                'description' =>
                    'Company archive was generated and verified.',

            ]);

        } catch (Throwable $exception) {

            report(
                $exception
            );


            $archive->update([

                'status' =>
                    'Failed',

                'error_message' =>
                    $exception
                        ->getMessage(),

            ]);


            $company->update([

                'lifecycle_status' =>
                    'Eligible',

                'lifecycle_locked' =>
                    false,

            ]);


            throw $exception;

        }
    }
}