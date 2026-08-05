<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController;
use App\Models\ProductStock;
use App\Models\ProductCategory;
use App\Models\Branch;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\ActivityLogger;
use App\Models\StockMovement;
use Illuminate\Support\Facades\Auth;


class StockController extends BaseController
{

    protected ActivityLogger $activityLogger;


    public function __construct(ActivityLogger $activityLogger)
    {
        parent::__construct();

        $this->activityLogger = $activityLogger;
    }
    /*
    |--------------------------------------------------------------------------
    | Stock Page
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | Statistics
        |--------------------------------------------------------------------------
        */


        $stockQuery = ProductStock::query()

            ->where(
                'company_id',
                $this->companyId
            );

        $stats = [

            'products' =>

                (clone $stockQuery)
                    ->count(),


            'available' =>

                (clone $stockQuery)
                    ->where(
                        'quantity',
                        '>',
                        0
                    )
                    ->count(),


            'low' =>

                (clone $stockQuery)
                    ->whereColumn(
                        'quantity',
                        '<=',
                        'reorder_level'
                    )
                    ->where(
                        'quantity',
                        '>',
                        0
                    )
                    ->count(),

            'out' =>

                (clone $stockQuery)
                    ->where(
                        'quantity',
                        '<=',
                        0
                    )
                    ->count(),



        ];

        /*
        |--------------------------------------------------------------------------
        | Filters
        |--------------------------------------------------------------------------
        */


        $categories =
            ProductCategory::query()

                ->where(
                    'company_id',
                    $this->companyId
                )

                ->orderBy(
                    'name'
                )

                ->get();

        $branches =
            Branch::query()

                ->where(
                    'company_id',
                    $this->companyId
                )

                ->orderBy(
                    'name'
                )

                ->get();
        /*
        |--------------------------------------------------------------------------
        | Initial Table Data
        |--------------------------------------------------------------------------
        */


        $stocks =
            ProductStock::query()


                ->where(
                    'company_id',
                    $this->companyId
                )


                ->with([

                    'product.category',

                    'branch'

                ])


                ->latest()


                ->paginate(15);

        return view(
            'stock.index',
            compact(

                'stats',

                'categories',

                'branches',

                'stocks'

            )
        );


    }

   /*
    |--------------------------------------------------------------------------
    | Stock Table
    |--------------------------------------------------------------------------
    */

    public function table(Request $request)
    {
          $stocks = ProductStock::query()



            ->where(
                'company_id',
                $this->companyId
            )



            ->with([


                'product.category',


                'branch',



            ])
            
            /*
            |--------------------------------------------------------------------------
            | Search
            |--------------------------------------------------------------------------
            */

            ->when(
                $request->search,
                function($query) use ($request){


                    $search =
                        $request->search;



                    $query->whereHas(
                        'product',
                        function($q) use ($search){


                            $q->where(
                                'name',
                                'like',
                                "%{$search}%"
                            )


                            ->orWhere(
                                'sku',
                                'like',
                                "%{$search}%"
                            )


                            ->orWhere(
                                'barcode',
                                'like',
                                "%{$search}%"
                            );


                        }
                    );


                }
            )

            /*
            |--------------------------------------------------------------------------
            | Category Filter
            |--------------------------------------------------------------------------
            */

            ->when(
                $request->category_id,
                function($query) use ($request){


                    $query->whereHas(
                        'product',
                        function($q) use ($request){


                            $q->where(
                                'category_id',
                                $request->category_id
                            );


                        }
                    );


                }
            )

            /*
            |--------------------------------------------------------------------------
            | Branch Filter
            |--------------------------------------------------------------------------
            */

            ->when(
                $request->branch_id,
                function($query) use ($request){


                    $query->where(
                        'branch_id',
                        $request->branch_id
                    );


                }
            )

            /*
            |--------------------------------------------------------------------------
            | Stock Status Filter
            |--------------------------------------------------------------------------
            */

            ->when(
                $request->status,
                function($query) use ($request){


                    if(
                        $request->status === 'low'
                    )
                    {


                        $query->whereColumn(
                            'quantity',
                            '<=',
                            'reorder_level'
                        );


                    }

                    if(
                        $request->status === 'out'
                    )
                    {


                        $query->where(
                            'quantity',
                            '<=',
                            0
                        );


                    }



                }
            )

            ->latest()

            ->paginate(15)

            ->withQueryString();

        return view(
            'stock.partials.table',
            compact('stocks')
        );

    }

    public function products(Request $request)
    {
        \Log::info(
            'Stock Product Filters',
            $request->all()
        );

        $products = Product::query()


            ->where(
                'company_id',
                $this->companyId
            )



            ->with([

                'category',

                'unit',

                'stocks'=>function($query) use ($request){

                    if($request->branch){

                        $query->where(
                            'branch_id',
                            $request->branch
                        );

                    }

                }

            ])

            /*
            |--------------------------------------------------------------------------
            | Search
            |--------------------------------------------------------------------------
            */

            ->when(
                $request->search,
                function($query) use ($request){


                    $search =
                        $request->search;



                    $query->where(function($q) use ($search){


                        $q->where(
                            'name',
                            'like',
                            "%{$search}%"
                        )

                        ->orWhere(
                            'sku',
                            'like',
                            "%{$search}%"
                        )

                        ->orWhere(
                            'barcode',
                            'like',
                            "%{$search}%"
                        );



                    });



                }
            )

            /*
            |--------------------------------------------------------------------------
            | Category Filter
            |--------------------------------------------------------------------------
            */

           ->when(
                $request->category,
                function($query) use ($request){


                    $query->where(
                        'product_category_id',
                        $request->category
                    );


                }
            )

            /*
            |--------------------------------------------------------------------------
            | Stock Status Filter
            |--------------------------------------------------------------------------
            */

            ->when(
                $request->status,
                function($query) use ($request){


                    $query->whereHas(
                        'stocks',
                        function($stock) use ($request)
                        {


                            if($request->status === 'in_stock')
                            {

                                $stock->where(
                                    'quantity',
                                    '>',
                                    0
                                );

                            }



                            if($request->status === 'low_stock')
                            {

                                $stock->whereColumn(
                                    'quantity',
                                    '<=',
                                    'reorder_level'
                                );

                            }




                            if($request->status === 'out_stock')
                            {

                                $stock->where(
                                    'quantity',
                                    '<=',
                                    0
                                );

                            }


                        }
                    );


                }
            )

            /*
            |--------------------------------------------------------------------------
            | Price Search
            |--------------------------------------------------------------------------
            */

            ->when(
                $request->price,
                function($query) use ($request){


                    $query->where(
                        'selling_price',
                        $request->price
                    );


                }
            )

            ->latest()

            ->paginate(5);

        return response()->json([


            'success'=>true,


            'data'=>$products->items(),


            'pagination'=>[


                'current_page'=>
                    $products->currentPage(),


                'last_page'=>
                    $products->lastPage(),


                'total'=>
                    $products->total()


            ]



        ]);

    }    

   /*
    |--------------------------------------------------------------------------
    | Stock Details
    |--------------------------------------------------------------------------
    */

    public function details($id)
    {
        $stock = ProductStock::query()

            ->where(
                'company_id',
                $this->companyId
            )

            ->with([

                'product.category',

                'branch',

            ])



            ->findOrFail($id);

        $movements = StockMovement::query()

            ->where(
                'company_id',
                $this->companyId
            )

            ->where(
                'product_id',
                $stock->product_id
            )

            ->where(
                'branch_id',
                $stock->branch_id
            )

            ->with([

                'user'

            ])

            ->latest()


            ->limit(10)


            ->get();

        return response()->json([

            'success' => true,

            'data' => [

                'id' => $stock->id,


                'product' => [

                    'name' =>
                        $stock->product->name,

                    'sku' =>
                        $stock->product->sku,

                    'barcode' =>
                        $stock->product->barcode,

                    'image' =>
                        $stock->product->image,


                    'category' => [

                        'name' =>
                            $stock->product->category->name ?? '-',

                    ],


                    'unit' => [

                        'name' =>
                            $stock->product->unit->name ?? '-',

                    ],


                ],



                'branch' => [

                    'name' =>
                        $stock->branch->name ?? '-',

                ],



                'quantity' =>
                    $stock->quantity,


                'reserved_quantity' =>
                    $stock->reserved_quantity,


                'available_quantity' =>
                    $stock->available_quantity,



                'reorder_level' =>
                    $stock->reorder_level,



                'movements' =>

                    $movements->map(function($movement){

                        return [

                            'movement_type' =>
                                $movement->movement_type,


                            'quantity' =>
                                $movement->quantity,


                            'stock_before' =>
                                $movement->stock_before,


                            'stock_after' =>
                                $movement->stock_after,


                            'user' => [

                                'name' =>
                                    $movement->user->name ?? 'System',

                            ],

                        ];

                    })

            ]

        ]);

    }

    /**
     * Adjustment Filters
     */
    public function adjustmentFilters()
    {

        $categories =
            ProductCategory::query()

                ->where(
                    'company_id',
                    $this->companyId
                )

                ->where(
                    'status',
                    true
                )

                ->orderBy(
                    'name'
                )

                ->get([
                    'id',
                    'name'
                ]);



        $branches =
            Branch::query()

                ->where(
                    'company_id',
                    $this->companyId
                )

                ->where(
                    'status',
                    true
                )

                ->orderBy(
                    'name'
                )

                ->get([
                    'id',
                    'name'
                ]);



        return response()->json([

            'success'=>true,


            'categories'=>$categories,


            'branches'=>$branches,


        ]);

    }

    /*
    |--------------------------------------------------------------------------
    | Store Stock Adjustment
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $validated = $request->validate([

            'product_id' => [

                'required',

                'integer',

            ],

            'branch_id' => [

                'required',

                'integer',

            ],

            'type' => [

                'required',

                'string',

                'max:50',

            ],

            'quantity' => [

                'required',

                'numeric',

                'min:0.01',

            ],

            'reason' => [

                'nullable',

                'string',

                'max:255',

            ],



        ]);

        return DB::transaction(function() use ($validated){
            /*
            |--------------------------------------------------------------------------
            | Get Stock Record
            |--------------------------------------------------------------------------
            */


            $stock = ProductStock::query()


                ->where(
                    'company_id',
                    $this->companyId
                )


                ->where(
                    'branch_id',
                    $validated['branch_id']
                )


                ->where(
                    'product_id',
                    $validated['product_id']
                )


                ->first();

            if(!$stock)
            {


                $stock = ProductStock::create([


                    'company_id'=>
                        $this->companyId,


                    'branch_id'=>
                        $validated['branch_id'],


                    'product_id'=>
                        $validated['product_id'],


                    'quantity'=>0,


                    'reserved_quantity'=>0,


                    'available_quantity'=>0,


                    'reorder_level'=>0,


                ]);


            }

            /*
            |--------------------------------------------------------------------------
            | Capture Old Quantity
            |--------------------------------------------------------------------------
            */


            $oldQuantity =
                $stock->quantity;

            /*
            |--------------------------------------------------------------------------
            | Calculate New Quantity
            |--------------------------------------------------------------------------
            */


            $increaseTypes = [


                'Opening Stock',

                'Adjustment In',

                'Purchase',

                'Customer Return',

                'Transfer In'


            ];


            if(
                in_array(
                    $validated['type'],
                    $increaseTypes
                )
            )
            {

                $newQuantity =
                    $oldQuantity
                    +
                    $validated['quantity'];


            }
            else
            {
                $newQuantity =
                    $oldQuantity
                    -
                    $validated['quantity'];


            }

            if($newQuantity < 0)
            {

                return response()->json([


                    'success'=>false,

                    'message'=>
                    'Insufficient stock quantity.'

                ],422);


            }

            /*
            |--------------------------------------------------------------------------
            | Update Stock
            |--------------------------------------------------------------------------
            */


            $stock->update([


                'quantity'=>
                    $newQuantity,

                'available_quantity'=>

                    $newQuantity
                    -
                    $stock->reserved_quantity,

                'last_stock_update'=>

                    now()


            ]);

            /*
            |--------------------------------------------------------------------------
            | Create Movement
            |--------------------------------------------------------------------------
            */


            StockMovement::create([

                'company_id'=>
                    $this->companyId,

                'branch_id'=>
                    $validated['branch_id'],

                'product_id'=>
                    $validated['product_id'],

                'user_id'=>
                    auth()->id(),

                'movement_type'=>

                    $validated['type'],

                'quantity'=>

                    $validated['quantity'],

                'stock_before'=>

                    $oldQuantity,

                'stock_after'=>

                    $newQuantity,

                'remarks'=>

                    $validated['reason'] ?? null,



            ]);

            /*
            |--------------------------------------------------------------------------
            | Activity Log
            |--------------------------------------------------------------------------
            */


            $this->activityLogger->log(


                'Stock',


                'Updated',


                'Stock adjusted for product ID '
                .$validated['product_id'],


                $stock,


                [

                    'quantity'=>
                        $oldQuantity

                ],


                [

                    'quantity'=>
                        $newQuantity

                ]


            );

            return response()->json([


                'success'=>true,


                'message'=>

                    'Stock adjusted successfully.'



            ]);



        });



    }


    /*
    |--------------------------------------------------------------------------
    | Edit Adjustment
    |--------------------------------------------------------------------------
    */

    public function edit(
        int $id
    )
    {

        //

    }



    /*
    |--------------------------------------------------------------------------
    | Update Adjustment
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        int $id
    )
    {

        //

    }



    /*
    |--------------------------------------------------------------------------
    | Delete
    |--------------------------------------------------------------------------
    */

    public function destroy(
        int $id
    )
    {

        //

    }



    /*
    |--------------------------------------------------------------------------
    | Query Builder
    |--------------------------------------------------------------------------
    */

    private function stockQuery( ?Request $request = null)
    {

        return ProductStock::query()

            ->where(
                'company_id',
                $this->companyId
            )


            ->with([

                'product.category',

                'product.unit',

                'branch'

            ])


            ->when(
                $request?->search,
                function($query) use ($request){

                    $query->whereHas(
                        'product',
                        function($q) use ($request){

                            $q->where(
                                'name',
                                'like',
                                "%{$request->search}%"
                            )

                            ->orWhere(
                                'sku',
                                'like',
                                "%{$request->search}%"
                            )

                            ->orWhere(
                                'barcode',
                                'like',
                                "%{$request->search}%"
                            );

                        }
                    );

                }
            )


            ->when(
                $request?->branch,
                function($query) use ($request){

                    $query->where(
                        'branch_id',
                        $request->branch
                    );

                }
            )


            ->when(
                $request?->status,
                function($query) use ($request){


                    if(
                        $request->status === 'low_stock'
                    ){

                        $query->lowStock();

                    }


                    if(
                        $request->status === 'out_stock'
                    ){

                        $query->outOfStock();

                    }


                    if(
                        $request->status === 'in_stock'
                    ){

                        $query->whereColumn(
                            'quantity',
                            '>',
                            'reorder_level'
                        );

                    }


                }
            );


    }


}