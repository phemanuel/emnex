<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController;
use App\Services\InventoryReportService;
use Illuminate\Http\Request;

class InventoryReportController extends BaseController
{
    /*
    |--------------------------------------------------------------------------
    | Inventory Report Controller
    |--------------------------------------------------------------------------
    */

    public function __construct(
        protected InventoryReportService $inventoryReportService
    ) {
        parent::__construct();
    }

    /*
    |--------------------------------------------------------------------------
    | Index
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        abort_unless(canAccess('reports.inventory'), 403);

        $company = $this->company;
        $companyId = $this->companyId;

        $filters = $this->inventoryReportService->getFilters(
            $companyId,
            $request->user()
        );

        return view('reports.inventory.index', compact(
            'company',
            'filters'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | Report Data
    |--------------------------------------------------------------------------
    */

    public function data(Request $request)
    {
        abort_unless(canAccess('reports.inventory'), 403);

        $validated = $request->validate([
            'date_from' => ['nullable', 'date'],
            'date_to' => ['nullable', 'date', 'after_or_equal:date_from'],

            'branch_id' => ['nullable', 'integer'],
            'product_id' => ['nullable', 'integer'],
            'category_id' => ['nullable', 'integer'],

            'movement_type' => ['nullable', 'string', 'max:100'],
            'stock_status' => ['nullable', 'string', 'max:50'],

            'details' => ['nullable', 'boolean'],

            'page' => ['nullable', 'integer', 'min:1'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
        ]);

        $validated['company_id'] = $this->companyId;

        $report = $this->inventoryReportService->generate(
            $validated,
            $request->user()
        );

        return response()->json([
            'success' => true,
            'data' => $report,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Export
    |--------------------------------------------------------------------------
    */

    public function export(Request $request)
    {
        abort_unless(canAccess('reports.inventory'), 403);

        $validated = $request->validate([
            'date_from' => ['nullable', 'date'],
            'date_to' => ['nullable', 'date', 'after_or_equal:date_from'],

            'branch_id' => ['nullable', 'integer'],
            'product_id' => ['nullable', 'integer'],
            'category_id' => ['nullable', 'integer'],

            'movement_type' => ['nullable', 'string', 'max:100'],
            'stock_status' => ['nullable', 'string', 'max:50'],

            'format' => ['required', 'in:xlsx,csv,pdf'],
        ]);

        $validated['company_id'] = $this->companyId;

        return $this->inventoryReportService->export(
            $validated,
            $request->user()
        );
    }
}