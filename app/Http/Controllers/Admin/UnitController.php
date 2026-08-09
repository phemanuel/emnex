<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController;
use App\Models\DocumentSequence;
use App\Models\Unit;
use Illuminate\Http\Request;
use App\Services\ActivityLogger;
use Illuminate\Support\Facades\DB;

class UnitController extends BaseController
{
    //
    protected ActivityLogger $activityLogger;


    public function __construct(ActivityLogger $activityLogger)
    {
        parent::__construct();

        $this->activityLogger = $activityLogger;
    }

    /*
    |--------------------------------------------------------------------------
    | Index
    |--------------------------------------------------------------------------
    */

    public function index()
    {

        return view(
            'units.index'
        );

    }

    public function table(Request $request)
    {
        $query = Unit::with([
            'createdBy'
        ])->forCompany($this->companyId);

        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where('unit_code', 'like', "%{$search}%")
                ->orWhere('name', 'like', "%{$search}%")
                ->orWhere('short_name', 'like', "%{$search}%");

            });
        }

        if ($request->filled('status') && $request->status !== '') {

            $query->where('status', $request->status);

        }

        $units = $query->latest()->paginate(15);

        return response()->json([

            'success' => true,

            'html' => view(
                'units.partials.table',
                compact('units')
            )->render(),

            'statistics' => [

                'total' => Unit::where('company_id', $this->companyId)->count(),

                'active' => Unit::where('company_id', $this->companyId)
                                ->where('status', true)
                                ->count(),

                'inactive' => Unit::where('company_id', $this->companyId)
                                ->where('status', false)
                                ->count(),

            ]

        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Details
    |--------------------------------------------------------------------------
    */

    public function details($id)
    {
        // Details
        if (! canAccess('units.view')) {
            return response()->json([
                'status' => false,
                'message' => 'You do not have permission to view units.'
            ], 403);
        }

        $unit = Unit::with([

                'createdBy',

                'updatedBy'

            ])

            ->forCompany($this->companyId)

            ->findOrFail($id);



        return response()->json([

            'success'=>true,

            'data'=>$unit

        ]);

    }

    /*
    |--------------------------------------------------------------------------
    | Next Code
    |--------------------------------------------------------------------------
    */

    public function nextCode()
    {

        $sequence = DocumentSequence::where(

            'company_id',

            $this->companyId

        )

        ->where(

            'document_type',

            'unit'

        )

        ->first();



        if(!$sequence)
        {

            return response()->json([

                'success'=>false,

                'message'=>'Document sequence not found.'

            ]);

        }



        $lastUnit = Unit::where(

                'company_id',

                $this->companyId

            )

            ->latest('id')

            ->first();



        $lastNumber = 0;



        if($lastUnit)
        {

            preg_match(

                '/(\d+)$/',

                $lastUnit->unit_code,

                $matches

            );



            $lastNumber =

                isset($matches[1])

                ? (int)$matches[1]

                : 0;

        }



        $nextNumber =

            $lastNumber + 1;



        $code =

            $sequence->prefix .

            str_pad(

                $nextNumber,

                $sequence->number_length,

                '0',

                STR_PAD_LEFT

            );



        return response()->json([

            'success'=>true,

            'code'=>$code

        ]);

    }

    /*
    |--------------------------------------------------------------------------
    | Store
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {

        if (! canAccess('units.create')) {
            return response()->json([
                'status' => false,
                'message' => 'You do not have permission to create units.'
            ], 403);
        }

        $validated = $request->validate([

            'unit_code'   => ['required', 'string', 'max:50'],

            'name'        => ['required', 'string', 'max:255'],

            'short_name'  => ['required', 'string', 'max:50'],

            'description' => ['nullable', 'string'],

        ]);



        DB::beginTransaction();

        try{


            /*
            |--------------------------------------------------------------------------
            | Check Existing Active Unit Code
            |--------------------------------------------------------------------------
            */

            $existingCode = Unit::where(

                    'company_id',

                    $this->companyId

                )

                ->where(

                    'unit_code',

                    $validated['unit_code']

                )

                ->first();



            if($existingCode)
            {

                return response()->json([

                    'success'=>false,

                    'type'=>'warning',

                    'message'=>'Unit code already exists.'

                ]);

            }



            /*
            |--------------------------------------------------------------------------
            | Check Existing Active Name
            |--------------------------------------------------------------------------
            */

            $existingName = Unit::where(

                    'company_id',

                    $this->companyId

                )

                ->where(

                    'name',

                    $validated['name']

                )

                ->first();



            if($existingName)
            {

                return response()->json([

                    'success'=>false,

                    'type'=>'warning',

                    'message'=>'Unit name already exists.'

                ]);

            }



            /*
            |--------------------------------------------------------------------------
            | Check Existing Active Short Name
            |--------------------------------------------------------------------------
            */

            $existingShortName = Unit::where(

                    'company_id',

                    $this->companyId

                )

                ->where(

                    'short_name',

                    $validated['short_name']

                )

                ->first();



            if($existingShortName)
            {

                return response()->json([

                    'success'=>false,

                    'type'=>'warning',

                    'message'=>'Short name already exists.'

                ]);

            }



            /*
            |--------------------------------------------------------------------------
            | Check Deleted Record
            |--------------------------------------------------------------------------
            */

            $deletedUnit = Unit::onlyTrashed()

                ->where(

                    'company_id',

                    $this->companyId

                )

                ->where(function($query) use ($validated){

                    $query->where(

                        'unit_code',

                        $validated['unit_code']

                    )

                    ->orWhere(

                        'name',

                        $validated['name']

                    )

                    ->orWhere(

                        'short_name',

                        $validated['short_name']

                    );

                })

                ->first();



            if($deletedUnit)
            {

                $oldValues = $deletedUnit->getOriginal();



                $deletedUnit->restore();



                $deletedUnit->update([

                    'unit_code'   => $validated['unit_code'],

                    'name'        => $validated['name'],

                    'short_name'  => $validated['short_name'],

                    'description' => $validated['description'],

                    'status'      => true,

                    'updated_by'  => auth()->id(),

                ]);



                $this->activityLogger->log(

                    'Units',

                    'Restored',

                    'Restored unit: '.$deletedUnit->name,

                    $deletedUnit,

                    $oldValues,

                    $deletedUnit->fresh()->toArray()

                );



                DB::commit();



                return response()->json([

                    'success'=>true,

                    'type'=>'success',

                    'message'=>'Unit restored successfully.',

                    'data'=>$deletedUnit

                ]);

            }



            /*
            |--------------------------------------------------------------------------
            | Create Unit
            |--------------------------------------------------------------------------
            */

            $unit = Unit::create([

                'company_id' => $this->companyId,

                'unit_code'  => $validated['unit_code'],

                'name'       => $validated['name'],

                'short_name' => $validated['short_name'],

                'description'=> $validated['description'],

                'status'     => true,

                'created_by' => auth()->id(),

                'updated_by' => auth()->id(),

            ]);



            $this->activityLogger->log(

                'Units',

                'Created',

                'Created unit: '.$unit->name,

                $unit

            );



            DB::commit();



            return response()->json([

                'success'=>true,

                'type'=>'success',

                'message'=>'Unit created successfully.',

                'data'=>$unit

            ]);



        }catch(\Exception $e){

            DB::rollBack();

            return response()->json([

                'success'=>false,

                'type'=>'error',

                'message'=>'Unable to create unit.',

                'error'=>$e->getMessage()

            ],500);

        }

    }

    /*
    |--------------------------------------------------------------------------
    | Edit
    |--------------------------------------------------------------------------
    */

    public function edit($id)
    {

        $unit = Unit::where(

                'company_id',

                $this->companyId

            )

            ->findOrFail($id);



        return response()->json([

            'success' => true,

            'data'    => $unit

        ]);

    }

    /*
    |--------------------------------------------------------------------------
    | Update
    |--------------------------------------------------------------------------
    */

    public function update(Request $request, $id)
    {
        // Update
        if (! canAccess('units.edit')) {
            return response()->json([
                'status' => false,
                'message' => 'You do not have permission to edit units.'
            ], 403);
        }

        $validated = $request->validate([

            'unit_code'   => ['required', 'string', 'max:50'],

            'name'        => ['required', 'string', 'max:255'],

            'short_name'  => ['required', 'string', 'max:50'],

            'description' => ['nullable', 'string'],

        ]);



        DB::beginTransaction();

        try{


            $unit = Unit::where(

                    'company_id',

                    $this->companyId

                )

                ->findOrFail($id);



            /*
            |--------------------------------------------------------------------------
            | Check Unit Code
            |--------------------------------------------------------------------------
            */

            $exists = Unit::where(

                    'company_id',

                    $this->companyId

                )

                ->where(

                    'id',

                    '!=',

                    $unit->id

                )

                ->where(

                    'unit_code',

                    $validated['unit_code']

                )

                ->exists();



            if($exists)
            {

                return response()->json([

                    'success'=>false,

                    'type'=>'warning',

                    'message'=>'Unit code already exists.'

                ]);

            }



            /*
            |--------------------------------------------------------------------------
            | Check Name
            |--------------------------------------------------------------------------
            */

            $exists = Unit::where(

                    'company_id',

                    $this->companyId

                )

                ->where(

                    'id',

                    '!=',

                    $unit->id

                )

                ->where(

                    'name',

                    $validated['name']

                )

                ->exists();



            if($exists)
            {

                return response()->json([

                    'success'=>false,

                    'type'=>'warning',

                    'message'=>'Unit name already exists.'

                ]);

            }



            /*
            |--------------------------------------------------------------------------
            | Check Short Name
            |--------------------------------------------------------------------------
            */

            $exists = Unit::where(

                    'company_id',

                    $this->companyId

                )

                ->where(

                    'id',

                    '!=',

                    $unit->id

                )

                ->where(

                    'short_name',

                    $validated['short_name']

                )

                ->exists();



            if($exists)
            {

                return response()->json([

                    'success'=>false,

                    'type'=>'warning',

                    'message'=>'Short name already exists.'

                ]);

            }



            $oldValues = $unit->toArray();



            $unit->update([

                'unit_code'   => $validated['unit_code'],

                'name'        => $validated['name'],

                'short_name'  => $validated['short_name'],

                'description' => $validated['description'],

                'updated_by'  => auth()->id(),

            ]);



            $this->activityLogger->log(

                'Units',

                'Updated',

                'Updated unit: '.$unit->name,

                $unit,

                $oldValues,

                $unit->fresh()->toArray()

            );



            DB::commit();



            return response()->json([

                'success'=>true,

                'type'=>'success',

                'message'=>'Unit updated successfully.',

                'data'=>$unit

            ]);


        }catch(\Exception $e){

            DB::rollBack();



            return response()->json([

                'success'=>false,

                'type'=>'error',

                'message'=>'Unable to update unit.'

            ],500);

        }

    }

    /*
    |--------------------------------------------------------------------------
    | Toggle Status
    |--------------------------------------------------------------------------
    */

    public function toggleStatus(Request $request, $id)
    {
        // Toggle Status
        if (! canAccess('units.toggle_status')) {
            return response()->json([
                'status' => false,
                'message' => 'You do not have permission to change unit status.'
            ], 403);
        }

        try{


            $unit = Unit::where(

                    'company_id',

                    $this->companyId

                )

                ->findOrFail($id);



            $unit->update([

                'status'=>

                    !$unit->status,

                'updated_by'=>

                    auth()->id()

            ]);



            $action =

                $unit->status

                ?

                'Enabled'

                :

                'Disabled';



            $this->activityLogger->log(

                'Units',

                $action,

                "Unit {$action}: {$unit->name}",

                $unit

            );



            return response()->json([

                'success'=>true,

                'type'=>'success',

                'message'=>

                    "Unit {$action} successfully."

            ]);


        }catch(\Exception $e){


            return response()->json([

                'success'=>false,

                'type'=>'error',

                'message'=>

                    'Unable to update unit status.'

            ],500);

        }

    }

    /*
    |--------------------------------------------------------------------------
    | Delete
    |--------------------------------------------------------------------------
    */

    public function destroy($id)
    {
        // Destroy
        if (! canAccess('units.delete')) {
            return response()->json([
                'status' => false,
                'message' => 'You do not have permission to delete units.'
            ], 403);
        }

        DB::beginTransaction();

        try{


            $unit = Unit::where(

                    'company_id',

                    $this->companyId

                )

                ->findOrFail($id);



            $oldValues =

                $unit->toArray();



            $unit->delete();



            $this->activityLogger->log(

                'Units',

                'Deleted',

                'Deleted unit: '.$unit->name,

                $unit,

                $oldValues,

                []

            );



            DB::commit();



            return response()->json([

                'success'=>true,

                'type'=>'success',

                'message'=>

                    'Unit deleted successfully.'

            ]);


        }catch(\Exception $e){


            DB::rollBack();



            return response()->json([

                'success'=>false,

                'type'=>'error',

                'message'=>

                    'Unable to delete unit.'

            ],500);

        }

    }



}
