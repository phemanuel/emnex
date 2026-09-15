<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController;
use App\Services\SalesReportService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class SalesReportController extends BaseController
{
    /*
    |--------------------------------------------------------------------------
    | Sales Report Service
    |--------------------------------------------------------------------------
    |
    | The service contains the actual report queries, calculations,
    | filtering, role scoping and export preparation.
    |
    */

    protected SalesReportService $salesReportService;

    /*
    |--------------------------------------------------------------------------
    | Constructor
    |--------------------------------------------------------------------------
    */

    public function __construct(
        SalesReportService $salesReportService
    ) {
        parent::__construct();

        $this->salesReportService = $salesReportService;
    }

    /*
    |--------------------------------------------------------------------------
    | Sales Report Index
    |--------------------------------------------------------------------------
    |
    | Displays the Sales Report workspace.
    |
    | Route:
    | GET /reports/sales
    |
    */

    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | Permission
        |--------------------------------------------------------------------------
        */

        abort_unless(
            canAccess('reports.sales'),
            403
        );

        /*
        |--------------------------------------------------------------------------
        | Company Context
        |--------------------------------------------------------------------------
        |
        | BaseController provides the authenticated user's company context.
        |
        */

        $company = $this->company;
        $companyId = $this->companyId;

        /*
        |--------------------------------------------------------------------------
        | Report Filters
        |--------------------------------------------------------------------------
        |
        | The service prepares the selectable filter values while applying
        | the appropriate company and role scope.
        |
        */

        $filters = $this->salesReportService->getFilters(
            $companyId,
            request()->user()
        );

        /*
        |--------------------------------------------------------------------------
        | View
        |--------------------------------------------------------------------------
        */

        return view(
            'reports.sales.index',
            compact(
                'company',
                'filters'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Sales Report Data
    |--------------------------------------------------------------------------
    |
    | Returns all AJAX data required by the Sales Report dashboard.
    |
    | Route:
    | GET /reports/sales/data
    |
    */

    public function data(Request $request): JsonResponse
    {
        /*
        |--------------------------------------------------------------------------
        | Permission
        |--------------------------------------------------------------------------
        */

        abort_unless(
            canAccess('reports.sales'),
            403
        );

        /*
        |--------------------------------------------------------------------------
        | Validate Report Filters
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([

            /*
            | Date range
            */

            'date_from' => [
                'nullable',
                'date',
            ],

            'date_to' => [
                'nullable',
                'date',
                'after_or_equal:date_from',
            ],

            /*
            | Branch
            */

            'branch_id' => [
                'nullable',
                'integer',
            ],

            /*
            | Cashier
            */

            'cashier_id' => [
                'nullable',
                'integer',
            ],

            /*
            | Payment method
            */

            'payment_method' => [
                'nullable',
                'string',
                'in:Cash,Transfer,Card,Wallet',
            ],

            /*
            | Sales channel
            */

            'sales_channel' => [
                'nullable',
                'string',
                'max:50',
            ],

            /*
            | Customer
            */

            'customer_id' => [
                'nullable',
                'integer',
            ],

            /*
            | Category
            */

            'category_id' => [
                'nullable',
                'integer',
            ],

            /*
            | Product
            */

            'product_id' => [
                'nullable',
                'integer',
            ],

            /*
            | Transaction inspector
            */

            'transaction_id' => [
                'nullable',
                'integer',
            ],

            'details' => [
                'nullable',
                'boolean',
            ],

            /*
            | Pagination
            */

            'page' => [
                'nullable',
                'integer',
                'min:1',
            ],

            'per_page' => [
                'nullable',
                'integer',
                'min:10',
                'max:100',
            ],

        ]);

        /*
        |--------------------------------------------------------------------------
        | Company Context
        |--------------------------------------------------------------------------
        |
        | Never trust a company_id supplied by the browser.
        | Always force the authenticated user's company.
        |
        */

        $validated['company_id'] = $this->companyId;

        /*
        |--------------------------------------------------------------------------
        | Generate Report
        |--------------------------------------------------------------------------
        |
        | SalesReportService is responsible for:
        |
        | - completed sales
        | - company isolation
        | - branch/user scope
        | - date filtering
        | - cashier filtering
        | - payment filtering
        | - customer filtering
        | - category filtering
        | - product filtering
        | - KPI calculations
        | - chart datasets
        | - product performance
        | - category performance
        | - payment performance
        | - cashier performance
        | - customer performance
        | - transaction listing
        | - transaction inspector
        |
        */

        $report = $this->salesReportService->generate(
            $validated,
            $request->user()
        );

        /*
        |--------------------------------------------------------------------------
        | JSON Response
        |--------------------------------------------------------------------------
        */

        return response()->json([
            'success' => true,
            'data' => $report,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Sales Report Export
    |--------------------------------------------------------------------------
    |
    | Exports the report using the same filters and role scope as the
    | dashboard.
    |
    | Route:
    | GET /reports/sales/export
    |
    */

    public function export(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Permission
        |--------------------------------------------------------------------------
        |
        | Viewing and exporting are separate permissions.
        |
        */

        abort_unless(
            canAccess('reports.sales'),
            403
        );

        /*
        |--------------------------------------------------------------------------
        | Validate Export Filters
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([

            /*
            | Date range
            */

            'date_from' => [
                'nullable',
                'date',
            ],

            'date_to' => [
                'nullable',
                'date',
                'after_or_equal:date_from',
            ],

            /*
            | Branch
            */

            'branch_id' => [
                'nullable',
                'integer',
            ],

            /*
            | Cashier
            */

            'cashier_id' => [
                'nullable',
                'integer',
            ],

            /*
            | Payment method
            */

            'payment_method' => [
                'nullable',
                'string',
                'in:Cash,Transfer,Card,Wallet',
            ],

            /*
            | Sales channel
            */

            'sales_channel' => [
                'nullable',
                'string',
                'max:50',
            ],

            /*
            | Customer
            */

            'customer_id' => [
                'nullable',
                'integer',
            ],

            /*
            | Category
            */

            'category_id' => [
                'nullable',
                'integer',
            ],

            /*
            | Product
            */

            'product_id' => [
                'nullable',
                'integer',
            ],

            /*
            | Export format
            */

            'format' => [
                'required',
                'in:xlsx,csv,pdf',
            ],

        ]);

        /*
        |--------------------------------------------------------------------------
        | Company Context
        |--------------------------------------------------------------------------
        |
        | The company ID always comes from the authenticated session.
        |
        */

        $validated['company_id'] = $this->companyId;

        /*
        |--------------------------------------------------------------------------
        | Export
        |--------------------------------------------------------------------------
        |
        | The service applies the exact same filters and role scope used
        | by the report dashboard.
        |
        */

        return $this->salesReportService->export(
            $validated,
            $request->user()
        );
    }
}


