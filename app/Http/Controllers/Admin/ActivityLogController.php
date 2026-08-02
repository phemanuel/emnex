<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController;
use App\Models\ActivityLog;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;

class ActivityLogController extends BaseController
{
    public function __construct(
    protected ActivityLogger $activityLogger
    ) {

        parent::__construct();

    }
    /*
    |--------------------------------------------------------------------------
    | Display Audit Logs
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $query = ActivityLog::with([
                'user',
                'branch',
                'terminal'
            ])
            ->where('company_id', $this->companyId);

        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {


            $search = $request->search;


            $query->where(function ($q) use ($search) {


                $q->where('module', 'like', "%{$search}%")

                    ->orWhere('action', 'like', "%{$search}%")

                    ->orWhere('description', 'like', "%{$search}%")

                    ->orWhere('record_type', 'like', "%{$search}%")

                    ->orWhereHas('user', function ($user) use ($search) {


                        $user->where('first_name', 'like', "%{$search}%")

                            ->orWhere('last_name', 'like', "%{$search}%")

                            ->orWhere('email', 'like', "%{$search}%");


                    });


            });


        }

        /*
        |--------------------------------------------------------------------------
        | Module Filter
        |--------------------------------------------------------------------------
        */

        if ($request->filled('module')) {


            $query->where('module', $request->module);


        }

        /*
        |--------------------------------------------------------------------------
        | Action Filter
        |--------------------------------------------------------------------------
        */

        if ($request->filled('action')) {


            $query->where('action', $request->action);


        }

        $activityLogs = $query
            ->latest()
            ->paginate(20)
            ->withQueryString();

        /*
        |--------------------------------------------------------------------------
        | Statistics
        |--------------------------------------------------------------------------
        */

        /*
        |--------------------------------------------------------------------------
        | Statistics
        |--------------------------------------------------------------------------
        */

        $actionCounts = ActivityLog::where(
                'company_id',
                $this->companyId
            )
            ->selectRaw('action, COUNT(*) as total')
            ->groupBy('action')
            ->pluck('total', 'action');



        $statistics = [

            'total' => $actionCounts->sum(),


            'created' => $actionCounts->get(
                'Created',
                0
            ),


            'updated' => $actionCounts->get(
                'Updated',
                0
            ),


            'deleted' => $actionCounts->get(
                'Deleted',
                0
            ),


            'restored' => $actionCounts->get(
                'Restored',
                0
            ),


            'enabled' => $actionCounts->get(
                'Enabled',
                0
            ),


            'disabled' => $actionCounts->get(
                'Disabled',
                0
            ),


            'password_reset' => $actionCounts->get(
                'Password Reset',
                0
            ),


            'permissions_updated' => $actionCounts->get(
                'Permissions Updated',
                0
            ),

        ];

        /*
        |--------------------------------------------------------------------------
        | Filters
        |--------------------------------------------------------------------------
        */

        $modules = ActivityLog::where('company_id', $this->companyId)
            ->select('module')
            ->distinct()
            ->orderBy('module')
            ->pluck('module');

        $actions = ActivityLog::where('company_id', $this->companyId)
            ->select('action')
            ->distinct()
            ->orderBy('action')
            ->pluck('action');

        if ($request->ajax()) {

            return view(
                'activity-logs.partials.table',
                compact('activityLogs')
            );

        }


        return view('activity-logs.index', compact(
            'activityLogs',
            'statistics',
            'modules',
            'actions'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | Display Audit Log Details
    |--------------------------------------------------------------------------
    */

    public function show($id)
    {
        $activityLog = ActivityLog::with([
                'user',
                'branch',
                'terminal'
            ])
            ->where('company_id', $this->companyId)
            ->find($id);

        if (!$activityLog) {

            return response()->json([

                'success' => false,

                'message' => 'Audit log not found.'

            ], 404);
        }

        /*
        |--------------------------------------------------------------------------
        | Decode JSON Values
        |--------------------------------------------------------------------------
        */

        if (is_string($activityLog->old_values)) {

            $activityLog->old_values = json_decode(
                $activityLog->old_values,
                true
            );
        }

        if (is_string($activityLog->new_values)) {

            $activityLog->new_values = json_decode(
                $activityLog->new_values,
                true
            );
        }

        return response()->json([

            'success' => true,

            'data' => $activityLog

        ]);
    }
}