<?php

namespace App\Http\Controllers\Platform;

use App\Http\Controllers\Controller;
use App\Jobs\ArchiveCompanyJob;
use App\Models\Company;
use App\Models\CompanyArchive;
use App\Models\CompanyLifecycleEvent;
use App\Models\DataLifecycleSetting;
use App\Services\CompanyLifecycleService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DataLifecycleController extends Controller
{
    public function index(): View
    {
        $settings =
            DataLifecycleSetting::current();


        $companies =
            Company::query()
                ->orderByRaw(
                    "
                    CASE lifecycle_status

                        WHEN 'Eligible' THEN 1
                        WHEN 'Monitoring' THEN 2
                        WHEN 'Archive Ready' THEN 3
                        WHEN 'Scheduled' THEN 4
                        WHEN 'Archiving' THEN 5
                        WHEN 'Archived' THEN 6
                        ELSE 7

                    END
                    "
                )
                ->latest(
                    'last_activity_at'
                )
                ->paginate(30);


        $archives =
            CompanyArchive::query()
                ->latest()
                ->limit(10)
                ->get();


        $stats = [

            'active' =>
                Company::query()
                    ->where(
                        'lifecycle_status',
                        'Active'
                    )
                    ->count(),

            'monitoring' =>
                Company::query()
                    ->where(
                        'lifecycle_status',
                        'Monitoring'
                    )
                    ->count(),

            'eligible' =>
                Company::query()
                    ->where(
                        'lifecycle_status',
                        'Eligible'
                    )
                    ->count(),

            'archive_ready' =>
                Company::query()
                    ->where(
                        'lifecycle_status',
                        'Archive Ready'
                    )
                    ->count(),

            'archived' =>
                Company::query()
                    ->where(
                        'lifecycle_status',
                        'Archived'
                    )
                    ->count(),

        ];


        return view(
            'platform.data-lifecycle.index',
            compact(
                'settings',
                'companies',
                'archives',
                'stats'
            )
        );
    }


    public function scan(
        CompanyLifecycleService $service
    ): JsonResponse {

        $count =
            $service->scanAll();


        return response()->json([

            'success' =>
                true,

            'message' =>
                $count .
                ' companies were scanned.',

        ]);
    }


    public function updateSettings(
        Request $request
    ): JsonResponse {

        $data =
            $request->validate([

                'inactivity_days' =>
                    [
                        'required',
                        'integer',
                        'min:30',
                    ],

                'grace_period_days' =>
                    [
                        'required',
                        'integer',
                        'min:0',
                    ],

                'archive_disk' =>
                    [
                        'required',
                        'string',
                        'max:100',
                    ],

                'archive_directory' =>
                    [
                        'required',
                        'string',
                        'max:255',
                    ],

                'automatic_scheduling' =>
                    [
                        'nullable',
                        'boolean',
                    ],

            ]);


        $settings =
            DataLifecycleSetting::current();


        $settings->update([

            'inactivity_days' =>
                $data[
                    'inactivity_days'
                ],

            'grace_period_days' =>
                $data[
                    'grace_period_days'
                ],

            'archive_disk' =>
                $data[
                    'archive_disk'
                ],

            'archive_directory' =>
                trim(
                    $data[
                        'archive_directory'
                    ],
                    '/'
                ),

            'automatic_scheduling' =>
                $request->boolean(
                    'automatic_scheduling'
                ),

            /*
             * Purge remains deliberately disabled.
             */

            'automatic_purge' =>
                false,

            'updated_by' =>
                auth(
                    'platform'
                )->id(),

        ]);


        return response()->json([

            'success' =>
                true,

            'message' =>
                'Lifecycle policy updated.',

        ]);
    }


    public function scheduleArchive(
        Company $company
    ): JsonResponse {

        if (
            !in_array(
                $company->lifecycle_status,
                [
                    'Eligible',
                    'Archive Ready',
                ],
                true
            )
        ) {

            return response()->json(
                [
                    'success' =>
                        false,

                    'message' =>
                        'This company is not currently eligible for archival.',
                ],
                422
            );

        }


        if (
            $company->lifecycle_locked
        ) {

            return response()->json(
                [
                    'success' =>
                        false,

                    'message' =>
                        'A lifecycle operation is already running for this company.',
                ],
                422
            );

        }


        $settings =
            DataLifecycleSetting::current();


        $archive =
            CompanyArchive::create([

                'original_company_id' =>
                    $company->id,

                'company_name' =>
                    $company->name,

                'company_code' =>
                    $company->company_code
                    ?? null,

                'status' =>
                    'Pending',

                'archive_format' =>
                    'zip-json',

                'storage_disk' =>
                    $settings
                        ->archive_disk,

                'storage_path' =>
                    $settings
                        ->archive_directory,

                'requested_at' =>
                    now(),

                'requested_by' =>
                    auth(
                        'platform'
                    )->id(),

            ]);


        $oldStatus =
            $company
                ->lifecycle_status;


        $company->update([

            'lifecycle_status' =>
                'Scheduled',

            'archive_scheduled_at' =>
                now(),

            'lifecycle_locked' =>
                true,

        ]);


        CompanyLifecycleEvent::create([

            'company_id' =>
                $company->id,

            'archive_id' =>
                $archive->id,

            'event' =>
                'archive_scheduled',

            'from_status' =>
                $oldStatus,

            'to_status' =>
                'Scheduled',

            'description' =>
                'Archive generation was scheduled.',

            'platform_admin_id' =>
                auth(
                    'platform'
                )->id(),

        ]);


        ArchiveCompanyJob::dispatch(
            $archive->id
        );


        return response()->json([

            'success' =>
                true,

            'message' =>
                'Archive has been queued for generation.',

        ]);
    }


    public function downloadArchive(
        CompanyArchive $archive
    ): StreamedResponse {

        if (
            !$archive->storage_path
            ||
            !Storage::disk(
                $archive->storage_disk
            )->exists(
                $archive->storage_path
            )
        ) {

            abort(
                404,
                'Archive file not found.'
            );

        }


        return Storage::disk(
            $archive->storage_disk
        )->download(
            $archive->storage_path
        );
    }
}