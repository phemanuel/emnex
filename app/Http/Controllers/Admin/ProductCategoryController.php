<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController;
use App\Models\ProductCategory;
use App\Models\DocumentSequence;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;



class ProductCategoryController extends BaseController
{
    protected ActivityLogger $activityLogger;


    public function __construct(ActivityLogger $activityLogger)
    {
        parent::__construct();

        $this->activityLogger = $activityLogger;
    }


    /*
    |--------------------------------------------------------------------------
    | Display Categories
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {


        $query = ProductCategory::with([
            'parent'
        ])
        ->forCompany($this->companyId);




        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        if($request->filled('search'))
        {

            $search = $request->search;


            $query->where(function($q) use ($search){

                $q->where(
                    'name',
                    'like',
                    "%{$search}%"
                )
                ->orWhere(
                    'category_code',
                    'like',
                    "%{$search}%"
                );

            });


        }





        /*
        |--------------------------------------------------------------------------
        | Status Filter
        |--------------------------------------------------------------------------
        */


        if($request->filled('status'))
        {

            $query->where(
                'status',
                $request->status
            );

        }





        $categories = $query
            ->latest()
            ->paginate(15)
            ->withQueryString();





        if($request->ajax())
        {

            return response()->json([

                'success'=>true,

                'html'=>view(
                    'product_categories.partials.table',
                    compact('categories')
                )->render()

            ]);

        }




        return view(
            'product_categories.index',
            compact('categories')
        );


    }

    /*
    |--------------------------------------------------------------------------
    | Statistics
    |--------------------------------------------------------------------------
    */

    public function statistics()
    {


        $base = ProductCategory::forCompany(
            $this->companyId
        );



        return response()->json([


            'success'=>true,


            'data'=>[


                'total'=>(clone $base)
                    ->count(),


                'active'=>(clone $base)
                    ->where(
                        'status',
                        true
                    )
                    ->count(),


                'inactive'=>(clone $base)
                    ->where(
                        'status',
                        false
                    )
                    ->count(),


            ]


        ]);


    }

    /*
    |--------------------------------------------------------------------------
    | Generate Next Category Code
    |--------------------------------------------------------------------------
    */    

    public function nextCode()
    {

        /*
        |--------------------------------------------------------------------------
        | Get Document Sequence
        |--------------------------------------------------------------------------
        */


        $sequence = DocumentSequence::where(
                'company_id',
                $this->companyId
            )
            ->where(
                'document_type',
                'category'
            )
            ->first();



        if(!$sequence)
        {

            return response()->json([

                'success'=>false,

                'message'=>'Category document sequence not configured.'

            ]);

        }





        /*
        |--------------------------------------------------------------------------
        | Get Last Category Number
        |--------------------------------------------------------------------------
        */


        $lastCategory = ProductCategory::forCompany(
                $this->companyId
            )
            ->orderByDesc('id')
            ->first();




        $prefix = $sequence->prefix;


        $length = $sequence->number_length;





        if(!$lastCategory)
        {


            $nextNumber = 1;


        }
        else
        {


            /*
            | Extract numeric part
            |
            | CAT000009 => 000009
            |
            */


            preg_match(
                '/(\d+)$/',
                $lastCategory->category_code,
                $matches
            );



            if(isset($matches[1]))
            {

                $nextNumber =
                    intval($matches[1]) + 1;

            }
            else
            {

                $nextNumber = 1;

            }


        }

        /*
        |--------------------------------------------------------------------------
        | Format Number
        |--------------------------------------------------------------------------
        */


        $code =
            $prefix .
            str_pad(
                $nextNumber,
                $length,
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
    | Store Product Category
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {

        /*
        |--------------------------------------------------------------------------
        | Validation
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([

            'category_code' => [
                'required',
                'string',
                'max:255',
            ],

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'parent_id' => [
                'nullable',
                'integer',
            ],

            'sort_order' => [
                'nullable',
                'integer',
                'min:0',
            ],

        ]);


        /*
        |--------------------------------------------------------------------------
        | Prepare Values
        |--------------------------------------------------------------------------
        */

        $categoryCode = strtoupper(
            trim($validated['category_code'])
        );


        $categoryName = trim(
            $validated['name']
        );


        /*
        |--------------------------------------------------------------------------
        | Validate Parent Category
        |--------------------------------------------------------------------------
        |
        | The parent category must belong to the current company.
        |
        */

        if (! empty($validated['parent_id'])) {

            $parentExists = ProductCategory::forCompany(
                    $this->companyId
                )
                ->where(
                    'id',
                    $validated['parent_id']
                )
                ->exists();


            if (! $parentExists) {

                return response()->json([

                    'success' => false,

                    'message' => 'The selected parent category is invalid.',

                    'data' => null,

                ], 422);

            }

        }


        /*
        |--------------------------------------------------------------------------
        | Check Active Category Code
        |--------------------------------------------------------------------------
        */

        $activeCodeExists = ProductCategory::forCompany(
                $this->companyId
            )
            ->where(
                'category_code',
                $categoryCode
            )
            ->exists();


        if ($activeCodeExists) {

            return response()->json([

                'success' => false,

                'message' => 'Category code already exists for this company.',

                'data' => null,

            ], 422);

        }


        /*
        |--------------------------------------------------------------------------
        | Check Active Category Name
        |--------------------------------------------------------------------------
        */

        $activeNameExists = ProductCategory::forCompany(
                $this->companyId
            )
            ->where(
                'name',
                $categoryName
            )
            ->exists();


        if ($activeNameExists) {

            return response()->json([

                'success' => false,

                'message' => 'Category name already exists for this company.',

                'data' => null,

            ], 422);

        }


        /*
        |--------------------------------------------------------------------------
        | Check Deleted Category By Code
        |--------------------------------------------------------------------------
        */

        $deletedByCode = ProductCategory::onlyTrashed()
            ->forCompany($this->companyId)
            ->where(
                'category_code',
                $categoryCode
            )
            ->first();


        /*
        |--------------------------------------------------------------------------
        | Check Deleted Category By Name
        |--------------------------------------------------------------------------
        */

        $deletedByName = ProductCategory::onlyTrashed()
            ->forCompany($this->companyId)
            ->where(
                'name',
                $categoryName
            )
            ->first();


        /*
        |--------------------------------------------------------------------------
        | Prevent Conflicting Deleted Records
        |--------------------------------------------------------------------------
        |
        | Example:
        |
        | Deleted record 1 owns the submitted category code.
        | Deleted record 2 owns the submitted category name.
        |
        | Since the database has separate unique constraints for code and name,
        | neither record can safely be restored with the submitted values.
        |
        */

        if (
            $deletedByCode &&
            $deletedByName &&
            $deletedByCode->id !== $deletedByName->id
        ) {

            return response()->json([

                'success' => false,

                'message' => 'The category code and name belong to different deleted categories. Restore or permanently resolve the conflicting records before continuing.',

                'data' => null,

            ], 422);

        }


        /*
        |--------------------------------------------------------------------------
        | Deleted Category To Restore
        |--------------------------------------------------------------------------
        */

        $deletedCategory = $deletedByCode ?? $deletedByName;


        /*
        |--------------------------------------------------------------------------
        | Restore Or Create Category
        |--------------------------------------------------------------------------
        */

        return DB::transaction(function () use (
            $validated,
            $categoryCode,
            $categoryName,
            $deletedCategory
        ) {


            /*
            |--------------------------------------------------------------------------
            | Restore Deleted Category
            |--------------------------------------------------------------------------
            */

            if ($deletedCategory) {

                $oldValues = $deletedCategory->toArray();


                $deletedCategory->restore();


                $deletedCategory->update([

                    'category_code' => $categoryCode,

                    'name' => $categoryName,

                    'description' => $validated['description'] ?? null,

                    'parent_id' => $validated['parent_id'] ?? null,

                    'sort_order' => $validated['sort_order'] ?? 0,

                    'status' => true,

                    'updated_by' => auth()->id(),

                ]);


                $deletedCategory->refresh();


                $newValues = $deletedCategory->toArray();


                /*
                |--------------------------------------------------------------------------
                | Activity Log
                |--------------------------------------------------------------------------
                */

                $this->activityLogger->log(

                    'Product Categories',

                    'Restored',

                    'Restored product category: ' . $deletedCategory->name,

                    $deletedCategory,

                    $oldValues,

                    $newValues

                );


                return response()->json([

                    'success' => true,

                    'message' => 'Deleted category restored successfully.',

                    'data' => $deletedCategory,

                ]);

            }


            /*
            |--------------------------------------------------------------------------
            | Create New Category
            |--------------------------------------------------------------------------
            */

            $category = ProductCategory::create([

                'company_id' => $this->companyId,

                'category_code' => $categoryCode,

                'name' => $categoryName,

                'description' => $validated['description'] ?? null,

                'parent_id' => $validated['parent_id'] ?? null,

                'sort_order' => $validated['sort_order'] ?? 0,

                'status' => true,

                'created_by' => auth()->id(),

                'updated_by' => auth()->id(),

            ]);


            $category->refresh();


            $newValues = $category->toArray();


            /*
            |--------------------------------------------------------------------------
            | Activity Log
            |--------------------------------------------------------------------------
            */

            $this->activityLogger->log(

                'Product Categories',

                'Created',

                'Created product category: ' . $category->name,

                $category,

                null,

                $newValues

            );


            return response()->json([

                'success' => true,

                'message' => 'Category created successfully.',

                'data' => $category,

            ], 201);

        });

    }



    /*
    |--------------------------------------------------------------------------
    | Edit Category
    |--------------------------------------------------------------------------
    */

    public function edit($id)
    {


        $category = ProductCategory::forCompany(
                $this->companyId
            )
            ->findOrFail($id);



        return response()->json([

            'success'=>true,

            'data'=>$category

        ]);

    }








    /*
    |--------------------------------------------------------------------------
    | Update Category
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        $id
    )
    {


        $category = ProductCategory::forCompany(
                $this->companyId
            )
            ->findOrFail($id);




        $validated = $request->validate([

            'category_code'=>[
                'required',
                'string',
                'max:50'
            ],

            'name'=>[
                'required',
                'string',
                'max:255'
            ],

            'description'=>[
                'nullable',
                'string'
            ],

            'parent_id'=>[
                'nullable',
                'integer'
            ],

            'sort_order'=>[
                'nullable',
                'integer'
            ]

        ]);




        $duplicate = ProductCategory::forCompany(
                $this->companyId
            )
            ->where('id','!=',$id)
            ->where(function($query) use ($request){

                $query->where(
                    'category_code',
                    $request->category_code
                )
                ->orWhere(
                    'name',
                    $request->name
                );

            })
            ->first();



        if($duplicate)
        {

            return response()->json([

                'success'=>false,

                'message'=>'Another category already uses this information.'

            ]);

        }

        /*
        |--------------------------------------------------------------------------
        | Update Activity Log
        |--------------------------------------------------------------------------
        */


        $oldValues = $category->toArray();



        $category->update([

            'category_code' => $validated['category_code'],

            'name' => $validated['name'],

            'description' => $validated['description'] ?? null,

            'parent_id' => $validated['parent_id'] ?? null,

            'sort_order' => $validated['sort_order'] ?? 0,

            'status' => $validated['status'] ?? true,

            'updated_by' => auth()->id(),

        ]);



        $category->refresh();



        $newValues = $category->toArray();



        $this->activityLogger->log(

            'Product Categories',

            'Updated',

            'Updated category: '.$category->name,

            $category,

            $oldValues,

            $newValues

        );

        return response()->json([

            'success'=>true,

            'message'=>'Category updated successfully.',

            'data'=>$category

        ]);

    }


    /*
    |--------------------------------------------------------------------------
    | Category Details
    |--------------------------------------------------------------------------
    */

    public function details($id)
    {

        $category = ProductCategory::with([

            'parent',

            'createdBy',

            'updatedBy'

        ])

        ->forCompany($this->companyId)

        ->withTrashed()

        ->findOrFail($id);



        return response()->json([

            'success'=>true,

            'data'=>$category,

            'created'=>$category->createdBy,

        ]);

    }

    /*
    |--------------------------------------------------------------------------
    | Delete Category
    |--------------------------------------------------------------------------
    */

    public function destroy($id)
    {


        $category = ProductCategory::forCompany(
                $this->companyId
            )
            ->findOrFail($id);




        $category->update([

            'updated_by'=>auth()->id()

        ]);



        /*
        |--------------------------------------------------------------------------
        | Delete Activity Log
        |--------------------------------------------------------------------------
        */


        $oldValues = $category->toArray();



        $category->update([

            'updated_by' => auth()->id(),

        ]);



        $category->delete();



        $newValues = $category->toArray();



        $this->activityLogger->log(

            'Product Categories',

            'Deleted',

            'Deleted category: '.$category->name,

            $category,

            $oldValues,

            $newValues

        );

        return response()->json([

            'success'=>true,

            'message'=>'Category deleted successfully.'

        ]);

    }

    /*
    |--------------------------------------------------------------------------
    | Toggle Status
    |--------------------------------------------------------------------------
    */

    public function toggleStatus(Request $request, $id)
    {

        try {


            $category = ProductCategory::forCompany(

                $this->companyId

            )->findOrFail($id);



            $oldValues = $category->toArray();



            $category->update([

                'status' => !$category->status,

                'updated_by' => auth()->id()

            ]);



            $category->refresh();



            $action = $category->status

                ? 'Enabled'

                : 'Disabled';



            $newValues = $category->toArray();




            $this->activityLogger->log(

                'Product Categories',

                $action,

                "Category {$action}: ".$category->name,

                $category,

                $oldValues,

                $newValues

            );




            return response()->json([

                'success'=>true,

                'type'=>'success',

                'message'=>
                    "Category {$action} successfully.",

                'data'=>$category

            ]);



        } catch(\Exception $e) {


            return response()->json([

                'success'=>false,

                'type'=>'error',

                'message'=>
                    'Unable to update category status.'

            ],500);


        }

    }



}