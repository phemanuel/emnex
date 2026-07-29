<?php

namespace App\Services;

use App\Models\ActivityLog;

class ActivityLogger
{

    /**
     * Create activity log entry.
     */
    public function log(
        string $module,
        string $action,
        string $description,
        $record = null
    ): ActivityLog {


        return ActivityLog::create([

            'company_id' => auth()->user()?->company_id,

            'branch_id' => auth()->user()?->branch_id,

            'terminal_id' => session('terminal_id'),


            'user_id' => auth()->id(),


            'module' => $module,

            'action' => $action,

            'description' => $description,


            'record_type' => $record
                ? class_basename($record)
                : null,


            'record_id' => $record?->id,


            'url' => request()->path(),

            'method' => request()->method(),


            'ip_address' => request()->ip(),

            'user_agent' => request()->userAgent(),

        ]);

    }

}