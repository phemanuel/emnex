<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController;
use App\Models\Terminal;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use App\Services\ActivityLogger;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TerminalController extends BaseController
{

    public function __construct(
    protected ActivityLogger $activityLogger
    ) {

        parent::__construct();

    }

    
    /**
     * |--------------------------------------------------------------------------
     * | Terminal Listing
     * |--------------------------------------------------------------------------
     */
    public function index(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Base Query
        |--------------------------------------------------------------------------
        */

        $query = $this->terminalQuery($request);


        /*
        |--------------------------------------------------------------------------
        | Branch Access
        |--------------------------------------------------------------------------
        */

        $user = auth()->user();

        $canManageAllBranches = $user->isOwner()
            || $user->hasPermission('branches.view_all');

        if (! $canManageAllBranches) {

            $query->where(
                'branch_id',
                $user->branch_id
            );

        }


       /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {

            $search = trim($request->search);

            $query->where(function ($q) use ($search) {

                /*
                |--------------------------------------------------------------------------
                | Terminal
                |--------------------------------------------------------------------------
                */

                $q->where(
                    'terminal_code',
                    'like',
                    "%{$search}%"
                )

                ->orWhere(
                    'terminal_name',
                    'like',
                    "%{$search}%"
                )

                ->orWhere(
                    'device_name',
                    'like',
                    "%{$search}%"
                )

                ->orWhere(
                    'ip_address',
                    'like',
                    "%{$search}%"
                )


                /*
                |--------------------------------------------------------------------------
                | Branch
                |--------------------------------------------------------------------------
                */

                ->orWhereHas('branch', function ($branch) use ($search) {

                    $branch->where(
                        'name',
                        'like',
                        "%{$search}%"
                    );

                })


                /*
                |--------------------------------------------------------------------------
                | Current Cashier
                |--------------------------------------------------------------------------
                */

                ->orWhereHas('activeAssignment.user', function ($user) use ($search) {

                    $user->where(function ($userQuery) use ($search) {

                        $userQuery
                            ->where(
                                'first_name',
                                'like',
                                "%{$search}%"
                            )
                            ->orWhere(
                                'other_name',
                                'like',
                                "%{$search}%"
                            )
                            ->orWhere(
                                'last_name',
                                'like',
                                "%{$search}%"
                            )
                            ->orWhere(
                                'username',
                                'like',
                                "%{$search}%"
                            );

                    });

                });

            });

        }
        

        /*
        |--------------------------------------------------------------------------
        | Terminal Listing
        |--------------------------------------------------------------------------
        */

        $terminals = $query
            ->latest()
            ->paginate(15)
            ->withQueryString();


        /*
        |--------------------------------------------------------------------------
        | KPI Statistics
        |--------------------------------------------------------------------------
        */

        $statisticsQuery = Terminal::where(
            'company_id',
            $this->companyId
        );


        if (! $canManageAllBranches) {

            $statisticsQuery->where(
                'branch_id',
                $user->branch_id
            );

        }


        $totalTerminals = (clone $statisticsQuery)
            ->count();


        $activeTerminals = (clone $statisticsQuery)
            ->where(
                'status',
                true
            )
            ->count();


        $disabledTerminals = (clone $statisticsQuery)
            ->where(
                'status',
                false
            )
            ->count();


        $branchCount = (clone $statisticsQuery)
            ->whereNotNull('branch_id')
            ->distinct('branch_id')
            ->count('branch_id');


        /*
        |--------------------------------------------------------------------------
        | Branches
        |--------------------------------------------------------------------------
        */

        $branchesQuery = Branch::where(
            'company_id',
            $this->companyId
        )
        ->where(
            'status',
            true
        );


        if (! $canManageAllBranches) {

            $branchesQuery->where(
                'id',
                $user->branch_id
            );

        }


        $branches = $branchesQuery
            ->orderBy('name')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Response
        |--------------------------------------------------------------------------
        */

        return view(
            'terminals.index',
            compact(
                'terminals',
                'totalTerminals',
                'activeTerminals',
                'disabledTerminals',
                'branchCount',
                'branches'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Terminal Query
    |--------------------------------------------------------------------------
    */

    private function terminalQuery(Request $request)
    {
        $user = auth()->user();

        $canManageAllBranches =
            $user->isOwner()
            || $user->hasPermission('branches.view_all');

        $query = Terminal::with([
            'branch',
            'activeAssignment.user',
        ])
        ->where(
            'company_id',
            $this->companyId
        );

        /*
        |--------------------------------------------------------------------------
        | Branch Access
        |--------------------------------------------------------------------------
        */

        if (! $canManageAllBranches) {

            $query->where(
                'branch_id',
                $user->branch_id
            );

        }

        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {

            $search = trim(
                $request->search
            );

            $query->where(function ($q) use ($search) {

                $q->where(
                    'terminal_code',
                    'like',
                    "%{$search}%"
                )

                ->orWhere(
                    'terminal_name',
                    'like',
                    "%{$search}%"
                )

                ->orWhere(
                    'device_name',
                    'like',
                    "%{$search}%"
                )

                ->orWhere(
                    'ip_address',
                    'like',
                    "%{$search}%"
                )

                ->orWhereHas(
                    'branch',
                    function ($branch) use ($search) {

                        $branch->where(
                            'name',
                            'like',
                            "%{$search}%"
                        );

                    }
                )

                ->orWhereHas(
                    'activeAssignment.user',
                    function ($user) use ($search) {

                        $user->where(function ($userQuery) use ($search) {

                            $userQuery
                                ->where(
                                    'first_name',
                                    'like',
                                    "%{$search}%"
                                )
                                ->orWhere(
                                    'other_name',
                                    'like',
                                    "%{$search}%"
                                )
                                ->orWhere(
                                    'last_name',
                                    'like',
                                    "%{$search}%"
                                )
                                ->orWhere(
                                    'username',
                                    'like',
                                    "%{$search}%"
                                );

                        });

                    }
                );

            });

        }

        return $query;
    }

    /*
    |--------------------------------------------------------------------------
    | Terminal Table
    |--------------------------------------------------------------------------
    */

    public function table(Request $request)
    {
        $terminals = $this->terminalQuery($request)
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view(
            'terminals.partials.table',
            compact('terminals')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Store Terminal
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        if (! canAccess('terminals.create')) {
            return response()->json([
                'status'  => false,
                'message' => 'You do not have permission to create a terminal.'
            ], 403);
        }

        $validator = Validator::make($request->all(), [

            'branch_id' => [
                'required',
                'integer'
            ],

            'terminal_code' => [
                'required',
                'string',
                'max:50'
            ],

            'terminal_name' => [
                'required',
                'string',
                'max:100'
            ],

            'description' => [
                'nullable',
                'string',
                'max:255'
            ],

            'device_name' => [
                'nullable',
                'string',
                'max:150'
            ],

            'ip_address' => [
                'nullable',
                'ip'
            ],

        ]);


        if ($validator->fails()) {

            return response()->json([

                'success' => false,

                'type' => 'warning',

                'message' => $validator->errors()->first()

            ], 422);

        }



        /*
        |--------------------------------------------------------------------------
        | Validate Branch Ownership
        |--------------------------------------------------------------------------
        */

        $branch = Branch::where('company_id', $this->companyId)
            ->where('id', $request->branch_id)
            ->first();


        if (!$branch) {

            return response()->json([

                'success' => false,

                'type' => 'warning',

                'message' => 'The selected branch is invalid.'

            ], 422);

        }



        /*
        |--------------------------------------------------------------------------
        | Check Active Duplicate
        |--------------------------------------------------------------------------
        */

        $existing = Terminal::where('company_id', $this->companyId)
            ->where('terminal_code', $request->terminal_code)
            ->first();


        if ($existing) {

            return response()->json([

                'success' => false,

                'type' => 'warning',

                'message' => "The Terminal Code \"{$request->terminal_code}\" is already in use."

            ], 409);

        }



        /*
        |--------------------------------------------------------------------------
        | Check Soft Deleted Record
        |--------------------------------------------------------------------------
        */

        $deletedTerminal = Terminal::onlyTrashed()
            ->where('company_id', $this->companyId)
            ->where('terminal_code', $request->terminal_code)
            ->first();



        if ($deletedTerminal) {


            $deletedTerminal->restore();


            $deletedTerminal->update([

                'branch_id' => $request->branch_id,

                'terminal_name' => $request->terminal_name,

                'description' => $request->description,

                'device_name' => $request->device_name,

                'ip_address' => $request->ip_address,

                'status' => true,

            ]);



            $this->activityLogger->log(

                'Terminal Management',

                'Restored',

                "Restored terminal {$deletedTerminal->terminal_code}",

                $deletedTerminal,

                $oldValues,

                $deletedTerminal->fresh()->toArray()

            );



            return response()->json([

                'success' => true,

                'type' => 'success',

                'message' => 'A previously deleted terminal has been restored successfully.'

            ]);

        }



        /*
        |--------------------------------------------------------------------------
        | Create New Terminal
        |--------------------------------------------------------------------------
        */

        $terminal = Terminal::create([

            'company_id' => $this->companyId,

            'branch_id' => $request->branch_id,

            'terminal_code' => $request->terminal_code,

            'terminal_name' => $request->terminal_name,

            'description' => $request->description,

            'device_name' => $request->device_name,

            'ip_address' => $request->ip_address,

            'status' => true,

        ]);



        $this->activityLogger->log(

            'Terminal Management',

            'Created',

            "Terminal {$terminal->terminal_code} created",

            $terminal,

            [],

            $terminal->toArray()

        );



        return response()->json([

            'success' => true,

            'type' => 'success',

            'message' => 'Terminal created successfully.'

        ]);

    }

    /*
    |--------------------------------------------------------------------------
    | Edit Terminal
    |--------------------------------------------------------------------------
    */

    public function edit($id)
    {

        $terminal = Terminal::where('company_id', $this->companyId)
            ->where('id', $id)
            ->first();


        if(!$terminal){

            return response()->json([

                'success' => false,

                'type' => 'warning',

                'message' => 'Terminal not found.'

            ],404);

        }



        return response()->json([

            'success' => true,

            'terminal' => $terminal

        ]);

    }

    /*
    |--------------------------------------------------------------------------
    | Update Terminal
    |--------------------------------------------------------------------------
    */

    public function update(Request $request,$id)
    {
        if (! canAccess('terminals.update')) {
            return response()->json([
                'status'  => false,
                'message' => 'You do not have permission to update a terminal.'
            ], 403);
        }

        $terminal = Terminal::where('company_id',$this->companyId)
            ->where('id',$id)
            ->first();



        if(!$terminal){


            return response()->json([

                'success'=>false,

                'type'=>'warning',

                'message'=>'Terminal not found.'

            ],404);


        }




        $validated = $request->validate([


            'branch_id'=>[
                'required',
                'exists:branches,id'
            ],


            'terminal_code'=>[
                'required',
                'string',
                'max:255'
            ],


            'terminal_name'=>[
                'required',
                'string',
                'max:255'
            ],


            'device_name'=>[
                'nullable',
                'string',
                'max:255'
            ],


            'ip_address'=>[
                'nullable',
                'ip'
            ],


            'description'=>[
                'nullable',
                'string',
                'max:255'
            ]


        ]);





        // Ensure branch belongs to company

        $branchExists =
            Branch::where('id',$validated['branch_id'])
                ->where('company_id',$this->companyId)
                ->exists();



        if(!$branchExists){


            return response()->json([

                'success'=>false,

                'type'=>'warning',

                'message'=>'Invalid branch selected.'

            ],422);


        }





        $oldValues =
            $terminal->toArray();





        $terminal->update([


            'branch_id'=>
                $validated['branch_id'],


            'terminal_code'=>
                $validated['terminal_code'],


            'terminal_name'=>
                $validated['terminal_name'],


            'device_name'=>
                $validated['device_name'] ?? null,


            'ip_address'=>
                $validated['ip_address'] ?? null,


            'description'=>
                $validated['description'] ?? null,


        ]);





        $this->activityLogger->log(

            'Terminal Management',

            'Updated',

            "Updated terminal {$terminal->terminal_code}",

            $terminal,

            $oldValues,

            $terminal->fresh()->toArray()

        );





        return response()->json([


            'success'=>true,

            'type'=>'success',

            'message'=>'Terminal updated successfully.'


        ]);

    }

    /*
    |--------------------------------------------------------------------------
    | Delete Terminal
    |--------------------------------------------------------------------------
    */

    public function destroy($id)
    {
        if (! canAccess('terminals.delete')) {
            return response()->json([
                'status'  => false,
                'message' => 'You do not have permission to delete a terminal.'
            ], 403);
        }
        $terminal =
            Terminal::where('company_id',$this->companyId)
            ->where('id',$id)
            ->first();



        if(!$terminal){

            return response()->json([

                'success'=>false,

                'type'=>'warning',

                'message'=>'Terminal not found.'

            ],404);

        }



        $terminal->delete();



        $this->activityLogger->log(

            'Terminal Management',

            'Deleted',

            "Deleted terminal {$terminal->terminal_code}",

            $terminal

        );



        return response()->json([

            'success'=>true,

            'type'=>'success',

            'message'=>'Terminal deleted successfully.'

        ]);

    }

    /*
    |--------------------------------------------------------------------------
    | Toggle Terminal Status
    |--------------------------------------------------------------------------
    */

    public function toggleStatus($id)
    {
        if (! canAccess('terminals.update')) {
            return response()->json([
                'status'  => false,
                'message' => 'You do not have permission to change terminal status.'
            ], 403);
        }

        $terminal = Terminal::where('company_id',$this->companyId)
            ->where('id',$id)
            ->first();


        if(!$terminal){

            return response()->json([

                'success'=>false,

                'type'=>'warning',

                'message'=>'Terminal not found.'

            ],404);

        }



        $oldStatus =
            $terminal->status;



        $terminal->update([

            'status'=> !$terminal->status

        ]);



        $action =
            $terminal->status
            ?
            'Enabled'
            :
            'Disabled';



        $this->activityLogger->log(

            'Terminal Management',

            $action,

            "{$action} terminal {$terminal->terminal_code}",

            $terminal,

            [
                'status'=>$oldStatus
            ],

            [
                'status'=>$terminal->status
            ]

        );




        return response()->json([

            'success'=>true,

            'type'=>'success',

            'message'=>"Terminal successfully {$action}."

        ]);

    }

    /*
    |--------------------------------------------------------------------------
    | Terminal Inspector Details
    |--------------------------------------------------------------------------
    */

    public function details(Terminal $terminal)
    {
        if (! canAccess('terminals.view')) {
            return response()->json([
                'status'  => false,
                'message' => 'You do not have permission to view terminal details.'
            ], 403);
        }

        if($terminal->company_id !== $this->companyId){

            return response()->json([

                'success'=>false,

                'type'=>'warning',

                'message'=>'Terminal not found.'

            ],404);

        }



       $terminal->load([
            'branch',

            'activeAssignment.user',

            'assignments.user',

            'activityLogs' => function ($query) {
                $query
                    ->latest()
                    ->limit(10);
            },
        ]);



        return response()->json([

            'success'=>true,

            'terminal'=>$terminal

        ]);

    }

}