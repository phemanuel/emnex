<?php

namespace App\Services;

use App\Models\Company;
use App\Models\CompanyArchive;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use RuntimeException;
use ZipArchive;

class CompanyArchiveService
{
    protected array $excludedTables = [

        'platform_admins',

        'data_lifecycle_settings',

        'company_archives',

        'company_lifecycle_events',

        'migrations',

        'jobs',

        'failed_jobs',

        'job_batches',

        'password_reset_tokens',

        'sessions',

    ];


    public function build(
        CompanyArchive $archive
    ): CompanyArchive {

        $company =
            Company::query()
                ->findOrFail(
                    $archive
                        ->original_company_id
                );


        $directory =
            storage_path(
                'app/lifecycle-temp'
            );


        if (!is_dir($directory)) {

            mkdir(
                $directory,
                0755,
                true
            );

        }


        $filename =
            'company-' .
            $company->id .
            '-' .
            now()->format(
                'Ymd-His'
            ) .
            '.zip';


        $tempPath =
            $directory .
            DIRECTORY_SEPARATOR .
            $filename;


        $zip =
            new ZipArchive();


        if (
            $zip->open(
                $tempPath,
                ZipArchive::CREATE
                |
                ZipArchive::OVERWRITE
            )
            !== true
        ) {

            throw new RuntimeException(
                'Unable to create archive package.'
            );

        }


        $manifest = [

            'archive_version' =>
                1,

            'company_id' =>
                $company->id,

            'company_name' =>
                $company->name,

            'generated_at' =>
                now()->toIso8601String(),

            'format' =>
                'zip-json',

            'tables' =>
                [],

            'record_count' =>
                0,

        ];


        /*
         * Company record itself.
         */

        $companyData =
            $company
                ->attributesToArray();


        $zip->addFromString(

            'company.json',

            json_encode(
                $companyData,
                JSON_PRETTY_PRINT
                |
                JSON_UNESCAPED_UNICODE
            )

        );


        /*
         * Export every table directly scoped
         * through company_id.
         */

        $tables =
            Schema::getTableListing();


        foreach ($tables as $table) {

            if (
                in_array(
                    $table,
                    $this->excludedTables,
                    true
                )
            ) {

                continue;

            }


            if (
                !Schema::hasColumn(
                    $table,
                    'company_id'
                )
            ) {

                continue;

            }


            $rows =
                DB::table(
                    $table
                )
                ->where(
                    'company_id',
                    $company->id
                )
                ->get()
                ->map(
                    fn ($row) =>
                        (array) $row
                )
                ->values()
                ->all();


            $count =
                count(
                    $rows
                );


            $manifest['tables'][$table] =
                $count;


            $manifest['record_count'] +=
                $count;


            $zip->addFromString(

                'tables/' .
                $table .
                '.json',

                json_encode(
                    $rows,
                    JSON_PRETTY_PRINT
                    |
                    JSON_UNESCAPED_UNICODE
                )

            );

        }


        $zip->addFromString(

            'manifest.json',

            json_encode(
                $manifest,
                JSON_PRETTY_PRINT
                |
                JSON_UNESCAPED_UNICODE
            )

        );


        $zip->close();


        if (!file_exists($tempPath)) {

            throw new RuntimeException(
                'Archive file was not generated.'
            );

        }


        $checksum =
            hash_file(
                'sha256',
                $tempPath
            );


        $size =
            filesize(
                $tempPath
            );


        $disk =
            $archive
                ->storage_disk;


        $storagePath =
            trim(
                $archive
                    ->storage_path
                    ?: 'company-archives',
                '/'
            )
            .
            '/'
            .
            $filename;


        $stream =
            fopen(
                $tempPath,
                'r'
            );


        Storage::disk(
            $disk
        )->put(
            $storagePath,
            $stream
        );


        if (
            is_resource(
                $stream
            )
        ) {

            fclose(
                $stream
            );

        }


        if (
            !Storage::disk(
                $disk
            )->exists(
                $storagePath
            )
        ) {

            throw new RuntimeException(
                'Archive could not be verified in storage.'
            );

        }


        @unlink(
            $tempPath
        );


        $archive->update([

            'storage_path' =>
                $storagePath,

            'archive_size' =>
                $size,

            'checksum' =>
                $checksum,

            'manifest' =>
                $manifest,

            'completed_at' =>
                now(),

            'status' =>
                'Completed',

        ]);


        return $archive->fresh();
    }


    public function verify(
        CompanyArchive $archive
    ): bool {

        if (
            !$archive->storage_path
            ||
            !$archive->checksum
        ) {

            return false;

        }


        $disk =
            Storage::disk(
                $archive->storage_disk
            );


        if (
            !$disk->exists(
                $archive->storage_path
            )
        ) {

            return false;

        }


        $size =
            $disk->size(
                $archive->storage_path
            );


        $valid =
            $size > 0
            &&
            $archive->archive_size > 0;


        $archive->update([

            'verification' => [

                'storage_exists' =>
                    true,

                'expected_size' =>
                    $archive->archive_size,

                'stored_size' =>
                    $size,

                'size_valid' =>
                    $size ===
                    $archive->archive_size,

                'record_count' =>
                    $archive->manifest[
                        'record_count'
                    ]
                    ?? 0,

            ],

            'verified_at' =>
                $valid
                    ? now()
                    : null,

            'status' =>
                $valid
                    ? 'Verified'
                    : 'Verification Failed',

        ]);


        return $valid;
    }
}