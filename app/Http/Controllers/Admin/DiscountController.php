<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController;
use App\Models\Discount;
use Illuminate\Http\Request;
use App\Services\ActivityLogger;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class DiscountController extends BaseController
{
    public function __construct(
    protected ActivityLogger $activityLogger
    ) {

        parent::__construct();

    }

    /**
     * Display the Discounts page.
     */
    public function index()
    {
        $total = Discount::forCompany($this->companyId)->count();

        $active = Discount::forCompany($this->companyId)
            ->where('status', true)
            ->count();

        $inactive = Discount::forCompany($this->companyId)
            ->where('status', false)
            ->count();

        $current = Discount::forCompany($this->companyId)
            ->current()
            ->count();

        $discounts = Discount::forCompany($this->companyId)
            ->latest()
            ->paginate(10);

        return view('discounts.index', compact(
            'total',
            'active',
            'inactive',
            'current',
            'discounts'
        ));
    }
    /**
     * Load Discounts table.
     */
    public function table(Request $request)
    {
        try {

            $search = trim($request->get('search'));

            $status = $request->get('status');

            $discounts = Discount::query()
                ->forCompany($this->companyId)
                ->when($search, function ($query) use ($search) {

                    $query->where(function ($q) use ($search) {

                        $q->where('name', 'like', "%{$search}%")
                          ->orWhere('type', 'like', "%{$search}%");

                    });

                })
                ->when($status !== null && $status !== '', function ($query) use ($status) {

                    $query->where('status', $status);

                })
                ->latest()
                ->paginate(10);

            return view(
                'discounts.partials.table',
                compact('discounts')
            );

        } catch (Throwable $e) {

            Log::error('Discount table load failed.', [
                'company_id' => $this->companyId,
                'error'      => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'type'    => 'danger',
                'message' => 'Unable to load discounts.',
            ], 500);

        }
    }

    /**
     * Store a newly created discount.
     */
    public function store(Request $request)
    {
        try {

            $request->merge([
                'is_automatic' => $request->boolean('is_automatic'),
            ]);

            $validated = $request->validate([
                'name'         => ['required', 'string', 'max:255'],
                'type'         => ['required', 'in:Percentage,Fixed'],
                'value'        => ['required', 'numeric', 'min:0'],
                'start_date'   => ['required', 'date'],
                'end_date'     => ['required', 'date', 'after_or_equal:start_date'],
                'is_automatic' => ['nullable', 'boolean'],
            ]);

            DB::beginTransaction();

            /*
            |--------------------------------------------------------------------------
            | Check Active Duplicate
            |--------------------------------------------------------------------------
            */

            $existing = Discount::where('company_id', $this->companyId)
                ->whereRaw('LOWER(name) = ?', [strtolower(trim($validated['name']))])
                ->first();

            if ($existing) {

                DB::rollBack();

                return response()->json([
                    'success' => false,
                    'type'    => 'warning',
                    'message' => 'A discount with this name already exists.',
                ]);
            }

            /*
            |--------------------------------------------------------------------------
            | Restore Soft Deleted Record
            |--------------------------------------------------------------------------
            */

            $deleted = Discount::onlyTrashed()
                ->where('company_id', $this->companyId)
                ->whereRaw('LOWER(name) = ?', [strtolower(trim($validated['name']))])
                ->first();

            if ($deleted) {

                $deleted->restore();

                $deleted->update([
                    'type'         => $validated['type'],
                    'value'        => $validated['value'],
                    'start_date'   => $validated['start_date'],
                    'end_date'     => $validated['end_date'],
                    'is_automatic' => $validated['is_automatic'] ?? false,
                    'status'       => true,
                ]);

                $this->activityLogger->log(
                    'Discounts',
                    'Restored',
                    'Restored discount: ' . $deleted->name,
                    $deleted
                );

                DB::commit();

                return response()->json([
                    'success' => true,
                    'type'    => 'success',
                    'message' => 'Existing discount restored successfully.',
                ]);
            }

            /*
            |--------------------------------------------------------------------------
            | Create Discount
            |--------------------------------------------------------------------------
            */

            $discount = Discount::create([
                'company_id'   => $this->companyId,
                'name'         => trim($validated['name']),
                'type'         => $validated['type'],
                'value'        => $validated['value'],
                'start_date'   => $validated['start_date'],
                'end_date'     => $validated['end_date'],
                'is_automatic' => $validated['is_automatic'] ?? false,
                'status'       => true,
            ]);

            $this->activityLogger->log(
                'Discounts',
                'Created',
                'Created discount: ' . $discount->name,
                $discount
            );

            DB::commit();

            return response()->json([
                'success' => true,
                'type'    => 'success',
                'message' => 'Discount created successfully.',
            ]);

        } catch (Throwable $e) {

            DB::rollBack();

            Log::error('Discount creation failed.', [
                'company_id' => $this->companyId,
                'error'      => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'type'    => 'danger',
                'message' => 'Unable to create discount.',
            ], 500);
        }
    }

    /**
     * Get discount for editing.
     */
    public function edit(Discount $discount)
    {
        try {

            if ($discount->company_id !== $this->companyId) {

                return response()->json([
                    'success' => false,
                    'type'    => 'danger',
                    'message' => 'Discount not found.',
                ], 404);

            }

            return response()->json([
                'success' => true,
                'data' => [
                    'id'             => $discount->id,
                    'name'           => $discount->name,
                    'type'           => $discount->type,
                    'value'          => $discount->value,
                    'is_automatic'   => (bool) $discount->is_automatic,
                    'start_date'     => optional($discount->start_date)->format('Y-m-d'),
                    'end_date'       => optional($discount->end_date)->format('Y-m-d'),
                    'status'         => $discount->status,
                ],
            ]);

        } catch (Throwable $e) {

            Log::error('Failed to load discount for editing.', [
                'company_id' => $this->companyId,
                'discount_id'=> $discount->id ?? null,
                'error'      => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'type'    => 'danger',
                'message' => 'Unable to load discount.',
            ], 500);

        }
    }

    /**
     * Update the specified discount.
     */
    public function update(Request $request, Discount $discount)
    {
        try {

            if ($discount->company_id !== $this->companyId) {

                return response()->json([
                    'success' => false,
                    'type'    => 'danger',
                    'message' => 'Discount not found.',
                ], 404);

            }

            $request->merge([
                'is_automatic' => $request->boolean('is_automatic'),
            ]);

            $validated = $request->validate([
                'name'         => ['required', 'string', 'max:255'],
                'type'         => ['required', 'in:Percentage,Fixed'],
                'value'        => ['required', 'numeric', 'min:0'],
                'start_date'   => ['required', 'date'],
                'end_date'     => ['required', 'date', 'after_or_equal:start_date'],
                'is_automatic' => ['nullable', 'boolean'],
            ]);
            

            DB::beginTransaction();

            /*
            |--------------------------------------------------------------------------
            | Duplicate Check
            |--------------------------------------------------------------------------
            */

            $duplicate = Discount::where('company_id', $this->companyId)
                ->whereRaw('LOWER(name) = ?', [strtolower(trim($validated['name']))])
                ->where('id', '!=', $discount->id)
                ->exists();

            if ($duplicate) {

                DB::rollBack();

                return response()->json([
                    'success' => false,
                    'type'    => 'warning',
                    'message' => 'A discount with this name already exists.',
                ]);

            }

            $oldValues = $discount->toArray();

            $discount->update([
                'name'         => trim($validated['name']),
                'type'         => $validated['type'],
                'value'        => $validated['value'],
                'start_date'   => $validated['start_date'],
                'end_date'     => $validated['end_date'],
                'is_automatic' => $validated['is_automatic'] ?? false,
            ]);

            $newValues = $discount->fresh()->toArray();

            $this->activityLogger->log(
                'Discounts',
                'Updated',
                'Updated discount: ' . $discount->name,
                $discount,
                $oldValues,
                $newValues
            );

            DB::commit();

            return response()->json([
                'success' => true,
                'type'    => 'success',
                'message' => 'Discount updated successfully.',
            ]);

        } catch (Throwable $e) {

            DB::rollBack();

            Log::error('Discount update failed.', [
                'company_id' => $this->companyId,
                'discount_id'=> $discount->id ?? null,
                'error'      => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'type'    => 'danger',
                'message' => 'Unable to update discount.',
            ], 500);

        }
    }

    /**
     * Display the specified discount details.
     */
    public function details(Discount $discount)
    {
        try {

            if ($discount->company_id !== $this->companyId) {

                return response()->json([
                    'success' => false,
                    'type'    => 'danger',
                    'message' => 'Discount not found.',
                ], 404);

            }

            $discount->loadCount('products');

            return response()->json([
                'success' => true,
                'data'    => [
                    'id'             => $discount->id,
                    'name'           => $discount->name,
                    'type'           => $discount->type,
                    'value'          => $discount->value,
                    'display_value'  => $discount->displayValue(),
                    'is_automatic'   => $discount->is_automatic,
                    'start_date'     => optional($discount->start_date)->format('M d, Y'),
                    'end_date'       => optional($discount->end_date)->format('M d, Y'),
                    'status'         => $discount->status,
                    'is_current'     => $discount->isCurrent(),
                    'products_count' => $discount->products_count,
                    'created_at'     => optional($discount->created_at)->format('M d, Y h:i A'),
                    'updated_at'     => optional($discount->updated_at)->format('M d, Y h:i A'),
                ]
            ]);

        } catch (Throwable $e) {

            Log::error('Discount details failed.', [
                'company_id' => $this->companyId,
                'discount_id'=> $discount->id ?? null,
                'error'      => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'type'    => 'danger',
                'message' => 'Unable to load discount details.',
            ], 500);

        }
    }

    /**
     * Enable or disable the discount.
     */
    public function toggleStatus(Discount $discount)
    {
        try {

            if ($discount->company_id !== $this->companyId) {

                return response()->json([
                    'success' => false,
                    'type'    => 'danger',
                    'message' => 'Discount not found.',
                ], 404);

            }

            DB::beginTransaction();

            $oldValues = $discount->toArray();

            $discount->update([
                'status' => !$discount->status,
            ]);

            $action = $discount->status ? 'Enabled' : 'Disabled';

            $newValues = $discount->fresh()->toArray();

            $this->activityLogger->log(
                'Discounts',
                $action,
                "{$action} discount: {$discount->name}",
                $discount,
                $oldValues,
                $newValues
            );

            DB::commit();

            return response()->json([
                'success' => true,
                'type'    => 'success',
                'message' => "Discount {$action} successfully.",
            ]);

        } catch (Throwable $e) {

            DB::rollBack();

            Log::error('Discount status update failed.', [
                'company_id' => $this->companyId,
                'discount_id'=> $discount->id ?? null,
                'error'      => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'type'    => 'danger',
                'message' => 'Unable to update discount status.',
            ], 500);

        }
    }

    /**
     * Remove the specified discount.
     */
    public function destroy(Discount $discount)
    {
        try {

            if ($discount->company_id !== $this->companyId) {

                return response()->json([
                    'success' => false,
                    'type'    => 'danger',
                    'message' => 'Discount not found.',
                ], 404);

            }

            DB::beginTransaction();

            $oldValues = $discount->toArray();

            $name = $discount->name;

            $discount->delete();

            $this->activityLogger->log(
                'Discounts',
                'Deleted',
                'Deleted discount: ' . $name,
                $discount,
                $oldValues,
                null
            );

            DB::commit();

            return response()->json([
                'success' => true,
                'type'    => 'success',
                'message' => 'Discount deleted successfully.',
            ]);

        } catch (Throwable $e) {

            DB::rollBack();

            Log::error('Discount deletion failed.', [
                'company_id' => $this->companyId,
                'discount_id'=> $discount->id ?? null,
                'error'      => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'type'    => 'danger',
                'message' => 'Unable to delete discount.',
            ], 500);

        }
    }

}

