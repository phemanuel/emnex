<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

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


        /*
        |--------------------------------------------------------------------------
        | Stock Behaviour
        |--------------------------------------------------------------------------
        */

        'track_stock',


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

            'company_id' =>
                'integer',

            'product_category_id' =>
                'integer',

            'unit_id' =>
                'integer',

            'tax_rate_id' =>
                'integer',

            'discount_id' =>
                'integer',


            /*
            |--------------------------------------------------------------------------
            | Pricing
            |--------------------------------------------------------------------------
            */

            'cost_price' =>
                'decimal:2',

            'selling_price' =>
                'decimal:2',


            /*
            |--------------------------------------------------------------------------
            | Stock
            |--------------------------------------------------------------------------
            */

            'track_stock' =>
                'boolean',

            'minimum_stock' =>
                'decimal:2',

            'maximum_stock' =>
                'decimal:2',


            /*
            |--------------------------------------------------------------------------
            | Product Details
            |--------------------------------------------------------------------------
            */

            'weight' =>
                'decimal:2',

            'expiry_date' =>
                'date',


            /*
            |--------------------------------------------------------------------------
            | Status
            |--------------------------------------------------------------------------
            */

            'status' =>
                'boolean',

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
        return $this->belongsTo(
            Company::class,
            'company_id'
        );
    }


    /**
     * Category
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(
            ProductCategory::class,
            'product_category_id'
        );
    }


    /**
     * Unit
     */
    public function unit(): BelongsTo
    {
        return $this->belongsTo(
            Unit::class,
            'unit_id'
        );
    }


    /**
     * Tax Rate
     */
    public function taxRate(): BelongsTo
    {
        return $this->belongsTo(
            TaxRate::class,
            'tax_rate_id'
        );
    }


    /**
     * Discount
     */
    public function discount(): BelongsTo
    {
        return $this->belongsTo(
            Discount::class,
            'discount_id'
        );
    }


    /**
     * Product Stock Records
     *
     * Contains the stock quantity for each branch.
     */
    public function stocks(): HasMany
    {
        return $this->hasMany(
            ProductStock::class,
            'product_id'
        );
    }


    /**
     * Alias for Product Stock Records
     */
    public function productStocks(): HasMany
    {
        return $this->hasMany(
            ProductStock::class,
            'product_id'
        );
    }


    /**
     * Stock Movement History
     */
    public function stockMovements(): HasMany
    {
        return $this->hasMany(
            StockMovement::class,
            'product_id'
        );
    }


    /**
     * Order Items
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(
            OrderItem::class,
            'product_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Product Images
    |--------------------------------------------------------------------------
    |
    | Full ordered image gallery for the product.
    |
    */

    public function images(): HasMany
    {
        return $this->hasMany(
            ProductImage::class,
            'product_id'
        )
            ->orderBy(
                'sort_order'
            )
            ->orderBy(
                'id'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Primary Image
    |--------------------------------------------------------------------------
    |
    | The primary gallery image represents the cover image.
    |
    | products.image remains synchronized with this image for compatibility
    | with existing EMNEX code.
    |
    */

    public function primaryImage(): HasOne
    {
        return $this->hasOne(
            ProductImage::class,
            'product_id'
        )
            ->where(
                'is_primary',
                true
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Query Scopes
    |--------------------------------------------------------------------------
    */


    /**
     * Active products only.
     */
    public function scopeActive(
        Builder $query
    ): Builder {

        return $query->where(
            'status',
            true
        );

    }


    /**
     * Products belonging to company.
     */
    public function scopeForCompany(
        Builder $query,
        int $companyId
    ): Builder {

        return $query->where(
            'company_id',
            $companyId
        );

    }


    /**
     * Products belonging to category.
     */
    public function scopeCategory(
        Builder $query,
        int $categoryId
    ): Builder {

        return $query->where(
            'product_category_id',
            $categoryId
        );

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
        return (bool) $this->status;
    }

    /**
     * Determine whether inventory quantities are tracked for this product.
     */
   public function tracksStock(): bool
    {
        if ($this->track_stock === null) {
            return true;
        }

        return (bool) $this->track_stock;
    }


    /**
     * Check if product has expired.
     */
    public function isExpired(): bool
    {
        return $this->expiry_date !== null
            && $this->expiry_date->isPast();
    }


    /**
     * Check if expiry date is approaching.
     */
    public function isNearExpiry(
        int $days = 30
    ): bool {

        return $this->expiry_date !== null
            && now()->diffInDays(
                $this->expiry_date,
                false
            ) <= $days;

    }


    /**
     * Get current stock quantity across all branches.
     */
    public function totalStock(): float
    {
        return (float) $this
            ->stocks()
            ->sum('quantity');
    }


    /**
     * Check if product is out of stock.
     */
    public function isOutOfStock(): bool
    {
        /*
        |--------------------------------------------------------------------------
        | Non-stock Products
        |--------------------------------------------------------------------------
        |
        | Products that do not track inventory can never be out of stock.
        |
        */

        if (!$this->tracksStock()) {

            return false;

        }


        return $this->totalStock() <= 0;
    }


    /**
     * Check if stock is below minimum level.
     */
    public function isLowStock(): bool
    {
        /*
        |--------------------------------------------------------------------------
        | Non-stock Products
        |--------------------------------------------------------------------------
        */

        if (!$this->tracksStock()) {

            return false;

        }


        $stock =
            $this->totalStock();


        /*
        |--------------------------------------------------------------------------
        | Out Of Stock Is Not Low Stock
        |--------------------------------------------------------------------------
        |
        | Zero stock belongs exclusively to the Out of Stock KPI.
        |
        */

        if ($stock <= 0) {

            return false;

        }


        return $stock
            <= (float) (
                $this->minimum_stock
                ?? 0
            );
    }


    /**
     * Stock status.
     */
    public function stockStatus(): string
    {
        /*
        |--------------------------------------------------------------------------
        | Non-stock Product
        |--------------------------------------------------------------------------
        */

        if (!$this->tracksStock()) {

            return 'Not tracked';

        }


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
        /*
        |--------------------------------------------------------------------------
        | Non-stock Product
        |--------------------------------------------------------------------------
        */

        if (!$this->tracksStock()) {

            return 'secondary';

        }


        if ($this->isOutOfStock()) {

            return 'danger';

        }


        if ($this->isLowStock()) {

            return 'warning';

        }


        return 'success';
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
                (
                    $this->selling_price -
                    $this->cost_price
                )
                / $this->cost_price
            ) * 100,
            2
        );
    }   


    /**
     * Get product image URL.
     */
    public function imageUrl(): string
    {
        if (
            $this->image &&
            file_exists(
                public_path(
                    'uploads/products/' . $this->image
                )
            )
        ) {

            return asset(
                'uploads/products/' . $this->image
            );

        }

        return asset(
            'uploads/products/no-image.png'
        );
    }


    /**
     * Upload product image.
     */
    private function uploadImage($image): string
    {
        $filename =
            time() . '_' .
            uniqid() . '.' .
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
    private function deleteImage(
        ?string $image
    ): void {

        if (
            !$image ||
            !file_exists(
                public_path(
                    'uploads/products/' . $image
                )
            )
        ) {
            return;
        }

        unlink(
            public_path(
                'uploads/products/' . $image
            )
        );
    }
}