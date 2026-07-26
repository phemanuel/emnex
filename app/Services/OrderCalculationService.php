<?php

namespace App\Services;

use App\Models\Discount;
use App\Models\TaxRate;

class OrderCalculationService
{
    /**
     * Calculate order totals.
     */
    public static function calculate(
        array $items,
        ?int $discountId = null,
        ?int $taxRateId = null
    ): array {

        $subtotal = 0;
        $totalItems = 0;
        $totalQuantity = 0;

        foreach ($items as $item) {

            $lineTotal = $item['quantity'] * $item['price'];

            $subtotal += $lineTotal;

            $totalItems++;

            $totalQuantity += $item['quantity'];

        }

        $discount = self::calculateDiscount(
            $subtotal,
            $discountId
        );

        $tax = self::calculateTax(
            $subtotal - $discount,
            $taxRateId
        );

        $grandTotal = ($subtotal - $discount) + $tax;

        return [

            'subtotal' => round($subtotal, 2),

            'discount' => round($discount, 2),

            'tax' => round($tax, 2),

            'grand_total' => round($grandTotal, 2),

            'total_items' => $totalItems,

            'total_quantity' => $totalQuantity,

        ];

    }

    /**
     * Calculate discount.
     */
    protected static function calculateDiscount(
        float $subtotal,
        ?int $discountId
    ): float {

        if (!$discountId) {
            return 0;
        }

        $discount = Discount::find($discountId);

        if (!$discount || !$discount->status) {
            return 0;
        }

        if ($discount->type === 'Percentage') {

            return ($subtotal * $discount->value) / 100;

        }

        return min(
            $discount->value,
            $subtotal
        );

    }

    /**
     * Calculate tax.
     */
    protected static function calculateTax(
        float $taxableAmount,
        ?int $taxRateId
    ): float {

        if (!$taxRateId) {
            return 0;
        }

        $tax = TaxRate::find($taxRateId);

        if (!$tax || !$tax->status) {
            return 0;
        }

        return ($taxableAmount * $tax->rate) / 100;

    }
}