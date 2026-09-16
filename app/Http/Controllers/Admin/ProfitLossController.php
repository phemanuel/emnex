<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController;
use App\Services\ProfitLossService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProfitLossController extends BaseController
{
    /*
    |--------------------------------------------------------------------------
    | Constructor
    |--------------------------------------------------------------------------
    */

    public function __construct(
        protected ProfitLossService $profitLossService
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
        abort_unless(canAccess('report.profit_loss'), 403);

        $company = $this->company;
        $companyId = $this->companyId;

        $filters = $this->profitLossService->getFilters(
            $companyId,
            $request->user()
        );

        return view('reports.profit-loss.index', compact(
            'company',
            'filters'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | Report Data
    |--------------------------------------------------------------------------
    */

    public function data(Request $request): JsonResponse
    {
        abort_unless(canAccess('report.profit_loss'), 403);

        $validated = $request->validate([
            'date_from' => [
                'nullable',
                'date',
            ],

            'date_to' => [
                'nullable',
                'date',
                'after_or_equal:date_from',
            ],

            'branch_id' => [
                'nullable',
                'integer',
            ],

            'details' => [
                'nullable',
                'boolean',
            ],
        ]);

        $validated['company_id'] = $this->companyId;

        $report = $this->profitLossService->generate(
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
        abort_unless(canAccess('report.profit_loss'), 403);

        $validated = $request->validate([
            'date_from' => [
                'nullable',
                'date',
            ],

            'date_to' => [
                'nullable',
                'date',
                'after_or_equal:date_from',
            ],

            'branch_id' => [
                'nullable',
                'integer',
            ],

            'format' => [
                'required',
                'in:xlsx,csv,pdf',
            ],
        ]);

        $validated['company_id'] = $this->companyId;

        return $this->profitLossService->export(
            $validated,
            $request->user()
        );
    }
}

