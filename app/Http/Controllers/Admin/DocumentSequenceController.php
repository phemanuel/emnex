<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController;
use App\Models\DocumentSequence;
use Illuminate\Http\Request;
use App\Services\ActivityLogger;
use Illuminate\Support\Facades\DB;

class DocumentSequenceController extends BaseController
{
    protected ActivityLogger $activityLogger;


    public function __construct(ActivityLogger $activityLogger)
    {
        parent::__construct();

        $this->activityLogger = $activityLogger;
    }
    /**
     * Default document sequences.
     */
    private const DEFAULT_SEQUENCES = [

        'Invoice' => 'INV',

        'Receipt' => 'REC',

        'Sales Order' => 'SO',

        'Purchase Order' => 'PO',

        'Purchase Return' => 'PR',

        'Sales Return' => 'SR',

        'Customer' => 'CUS',

        'Supplier' => 'SUP',

        'Product' => 'PROD',

        'Stock Transfer' => 'ST',

        'Stock Adjustment' => 'ADJ',

    ];

    /**
     * Display document sequences.
     */
    public function index()
    {
        foreach (self::DEFAULT_SEQUENCES as $type => $prefix) {

            DocumentSequence::firstOrCreate(

                [

                    'company_id'    => $this->companyId,

                    'document_type' => $type,

                ],

                [

                    'prefix'           => $prefix,

                    'suffix'           => null,

                    'separator'        => '-',

                    'current_number'   => 1,

                    'number_length'    => 6,

                    'reset_frequency'  => 'Never',

                    'status'           => true,

                ]

            );

        }

        $documentSequences = DocumentSequence::where(
                'company_id',
                $this->companyId
            )
            ->orderBy('document_type')
            ->get();

        return view(
            'document-sequences.index',
            compact('documentSequences')
        );
    }

    /**
     * Get a document sequence for editing.
     */
    public function edit(DocumentSequence $documentSequence)
    {
        if ($documentSequence->company_id !== $this->companyId) {

            return response()->json([

                'success' => false,

                'type' => 'warning',

                'message' => 'Document sequence not found.'

            ], 404);

        }

        return response()->json([

            'success' => true,

            'sequence' => $documentSequence,

        ]);
    }

    /**
     * Update document sequence.
     */
    public function update(Request $request,DocumentSequence $documentSequence) 
    {
               /*
        |--------------------------------------------------------------------------
        | Company Ownership
        |--------------------------------------------------------------------------
        */

        if ($documentSequence->company_id !== $this->companyId) {

            return response()->json([

                'success' => false,

                'type'    => 'warning',

                'message' => 'Document sequence not found.'

            ], 404);

        }



        /*
        |--------------------------------------------------------------------------
        | Validation
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([

            'prefix' => [
                'required',
                'string',
                'max:20',
            ],

            'suffix' => [
                'nullable',
                'string',
                'max:20',
            ],

            'separator' => [
                'required',
                'string',
                'max:5',
            ],

            'current_number' => [
                'required',
                'integer',
                'min:1',
            ],

            'number_length' => [
                'required',
                'integer',
                'min:1',
                'max:12',
            ],

            'reset_frequency' => [
                'required',
                'in:Never,Daily,Monthly,Yearly',
            ],

        ]);



        /*
        |--------------------------------------------------------------------------
        | Update
        |--------------------------------------------------------------------------
        */

        $oldValues = $documentSequence->toArray();

        $documentSequence->update($validated);

        $newValues = $documentSequence->fresh()->toArray();



        /*
        |--------------------------------------------------------------------------
        | Activity Log
        |--------------------------------------------------------------------------
        */

        $this->activityLogger->log(

            'Document Sequences',

            'Updated',

            "Updated {$documentSequence->document_type} document sequence.",

            $documentSequence,

            $oldValues,

            $newValues

        );



        return response()->json([

            'success' => true,

            'type'    => 'success',

            'message' => "{$documentSequence->document_type} sequence updated successfully."

        ]);

    }

    /**
     * Enable / Disable document sequence.
     */
    public function toggleStatus(DocumentSequence $documentSequence) 
    {

        /*
        |--------------------------------------------------------------------------
        | Company Ownership
        |--------------------------------------------------------------------------
        */

        if ($documentSequence->company_id !== $this->companyId) {

            return response()->json([

                'success' => false,

                'type'    => 'warning',

                'message' => 'Document sequence not found.'

            ], 404);

        }



        $oldValues = $documentSequence->toArray();



        $documentSequence->update([

            'status' => ! $documentSequence->status

        ]);



        $newValues = $documentSequence->fresh()->toArray();



        $action = $documentSequence->status
            ? 'Enabled'
            : 'Disabled';



        $this->activityLogger->log(

            'Document Sequences',

            $action,

            "{$action} {$documentSequence->document_type} document sequence.",

            $documentSequence,

            $oldValues,

            $newValues

        );



        return response()->json([

            'success' => true,

            'type'    => 'success',

            'message' => "{$documentSequence->document_type} sequence {$action} successfully."

        ]);

    }


}