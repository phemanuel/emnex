<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Product Model
 *
 * Represents a product sold by a company.
 */
class Product extends Model
{
    use HasFactory, SoftDeletes;

    /*
    |--------------------------------------------------------------------------
    | Fillable
    |--------------------------------------------------------------------------
    */

    protected $fillable = [
        'company_id',
        'product_category_id',
        'unit_id',
        'tax_rate_id',
        'discount_id',

        'product_code',
        'sku',
        'barcode',
        'qr_code',

        'name',
        'description',
        'image',

        'brand',
        'manufacturer',

        'cost_price',
        'selling_price',

        'minimum_stock',
        'maximum_stock',

        'weight',

        'expiry_date',

        'status',
    ];

    /*
    |--------------------------------------------------------------------------
    | Casts
    |--------------------------------------------------------------------------
    */

    protected function casts(): array
    {
        return [
            'company_id'     => 'integer',
            'category_id'    => 'integer',
            'unit_id'        => 'integer',
            'tax_rate_id'    => 'integer',
            'discount_id'    => 'integer',

            'cost_price'     => 'decimal:2',
            'selling_price'  => 'decimal:2',

            'minimum_stock'  => 'decimal:2',
            'maximum_stock'  => 'decimal:2',

            'weight'         => 'decimal:2',

            'expiry_date'    => 'date',

            'status'         => 'boolean',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    /**
     * Company
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    /**
     * Category
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id');
    }

    /**
     * Unit
     */
    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }

    /**
     * Tax Rate
     */
    public function taxRate(): BelongsTo
    {
        return $this->belongsTo(TaxRate::class, 'tax_rate_id');
    }

    /**
     * Discount
     */
    public function discount(): BelongsTo
    {
        return $this->belongsTo(Discount::class, 'discount_id');
    }

    /**
     * Stock Records
     */
    public function productStocks(): HasMany
    {
        return $this->hasMany(ProductStock::class, 'product_id');
    }

    public function stocks()
    {
        return $this->hasMany(ProductStock::class);
    }

    /**
     * Stock Movement History
     */
    public function stockMovements(): HasMany
    {
        return $this->hasMany(StockMovement::class, 'product_id');
    }

    /**
     * Order Items
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'product_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Query Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', true);
    }

    public function scopeForCompany(Builder $query, int $companyId): Builder
    {
        return $query->where('company_id', $companyId);
    }

    public function scopeCategory(Builder $query, int $categoryId): Builder
    {
        return $query->where('category_id', $categoryId);
    }

    /*
    |--------------------------------------------------------------------------
    | Helper Methods
    |--------------------------------------------------------------------------
    */

    /**
     * Check if product is active.
     */
    public function isActive(): bool
    {
        return $this->status;
    }

    /**
     * Check if product has expired.
     */
    public function isExpired(): bool
    {
        return $this->expiry_date !== null &&
               $this->expiry_date->isPast();
    }

    /**
     * Check if expiry date is approaching.
     */
    public function isNearExpiry(int $days = 30): bool
    {
        return $this->expiry_date !== null &&
               now()->diffInDays($this->expiry_date, false) <= $days;
    }

    /**
     * Get current stock quantity across all branches.
     */
    public function totalStock(): float
    {
        return (float) $this->productStocks()->sum('quantity');
    }

    /**
     * Check if product is out of stock.
     */
    public function isOutOfStock(): bool
    {
        return $this->totalStock() <= 0;
    }

    /**
     * Check if stock is below minimum level.
     */
    public function isLowStock(): bool
    {
        return $this->totalStock() <= $this->minimum_stock;
    }

    /**
     * Product display name.
     */
    public function displayName(): string
    {
        return "{$this->product_code} - {$this->name}";
    }

    /**
     * Profit amount.
     */
    public function profitAmount(): float
    {
        return (float) (
            $this->selling_price -
            $this->cost_price
        );
    }

    /**
     * Profit margin (%)
     */
    public function profitMargin(): float
    {
        if ($this->cost_price <= 0) {
            return 0;
        }

        return round(
            (
                ($this->selling_price - $this->cost_price)
                / $this->cost_price
            ) * 100,
            2
        );
    }

    /**
     * Stock status.
     */
    public function stockStatus(): string
    {
        if ($this->isOutOfStock()) {
            return 'Out of Stock';
        }

        if ($this->isLowStock()) {
            return 'Low Stock';
        }

        return 'In Stock';
    }

    /**
     * Stock badge class.
     */
    public function stockBadge(): string
    {
        if ($this->isOutOfStock()) {
            return 'danger';
        }

        if ($this->isLowStock()) {
            return 'warning';
        }

        return 'success';
    }

    /**
     * Get product image URL.
     */
    public function imageUrl(): string
    {
        if (
            $this->image &&
            file_exists(public_path('uploads/products/' . $this->image))
        ) {
            return asset('uploads/products/' . $this->image);
        }

        return asset('uploads/products/no-image.png');
    }

    /**
     * Upload product image.
     */
    private function uploadImage($image): string
    {
        $filename = time() . '_' . uniqid() . '.' .
            $image->getClientOriginalExtension();

        $image->move(
            public_path('uploads/products'),
            $filename
        );

        return $filename;
    }

    /**
     * Delete product image.
     */
    private function deleteImage(?string $image): void
    {
        if (
            !$image ||
            !file_exists(public_path('uploads/products/' . $image))
        ) {
            return;
        }

        unlink(
            public_path('uploads/products/' . $image)
        );
    }

    
    
}