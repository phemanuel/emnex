<?php

namespace App\Services;

use App\Models\ProductStock;
use Illuminate\Support\Facades\DB;
use Exception;

class InventoryService
{
    /**
     * Increase stock.
     */
    public static function increaseStock(
        int $companyId,
        int $branchId,
        int $productId,
        float $quantity
    ): ProductStock {

        return DB::transaction(function () use (
            $companyId,
            $branchId,
            $productId,
            $quantity
        ) {

            $stock = ProductStock::lockForUpdate()
                ->where('company_id', $companyId)
                ->where('branch_id', $branchId)
                ->where('product_id', $productId)
                ->firstOrFail();

            $stock->quantity += $quantity;
            $stock->available_quantity += $quantity;

            $stock->save();

            return $stock;

        });

    }

    /**
     * Reduce stock.
     */
    public static function decreaseStock(
        int $companyId,
        int $branchId,
        int $productId,
        float $quantity
    ): ProductStock {

        return DB::transaction(function () use (
            $companyId,
            $branchId,
            $productId,
            $quantity
        ) {

            $stock = ProductStock::lockForUpdate()
                ->where('company_id', $companyId)
                ->where('branch_id', $branchId)
                ->where('product_id', $productId)
                ->firstOrFail();

            if ($stock->available_quantity < $quantity) {
                throw new Exception('Insufficient stock.');
            }

            $stock->quantity -= $quantity;
            $stock->available_quantity -= $quantity;

            $stock->save();

            return $stock;

        });

    }

    public static function reserveStock(
    int $companyId,
    int $branchId,
    int $productId,
    float $quantity
    ): ProductStock {

        return DB::transaction(function () use (
            $companyId,
            $branchId,
            $productId,
            $quantity
        ) {

            $stock = ProductStock::lockForUpdate()
                ->where('company_id', $companyId)
                ->where('branch_id', $branchId)
                ->where('product_id', $productId)
                ->firstOrFail();

            if ($stock->available_quantity < $quantity) {
                throw new Exception('Not enough available stock.');
            }

            $stock->reserved_quantity += $quantity;
            $stock->available_quantity -= $quantity;

            $stock->save();

            return $stock;

        });

    }

    public static function releaseReservedStock(
    int $companyId,
    int $branchId,
    int $productId,
    float $quantity
    ): ProductStock {

        return DB::transaction(function () use (
            $companyId,
            $branchId,
            $productId,
            $quantity
        ) {

            $stock = ProductStock::lockForUpdate()
                ->where('company_id', $companyId)
                ->where('branch_id', $branchId)
                ->where('product_id', $productId)
                ->firstOrFail();

            if ($stock->reserved_quantity < $quantity) {
                throw new Exception('Reserved quantity is insufficient.');
            }

            $stock->reserved_quantity -= $quantity;
            $stock->available_quantity += $quantity;

            $stock->save();

            return $stock;

        });

    }
    
}