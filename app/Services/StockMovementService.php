<?php

namespace App\Services;

use App\Models\StockMovement;

class StockMovementService
{
    /**
     * Record a stock movement.
     */
    public static function record(
        int $companyId,
        int $branchId,
        int $productId,
        string $movementType,
        float $quantity,
        float $stockBefore,
        float $stockAfter,
        ?string $referenceType = null,
        ?int $referenceId = null,
        ?string $remarks = null
    ): StockMovement {

        return StockMovement::create([

            'company_id'      => $companyId,

            'branch_id'       => $branchId,

            'product_id'      => $productId,

            'movement_type'   => $movementType,

            'quantity'        => $quantity,

            'stock_before'    => $stockBefore,

            'stock_after'     => $stockAfter,

            'reference_type'  => $referenceType,

            'reference_id'    => $referenceId,

            'remarks'         => $remarks,

            'created_by'      => auth()->id(),

        ]);

    }
}