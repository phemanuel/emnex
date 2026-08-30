<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CashDrawer extends Model
{
    use HasFactory;

    /*
    |--------------------------------------------------------------------------
    | Fillable
    |--------------------------------------------------------------------------
    */

    protected $fillable = [

        'company_id',
        'branch_id',
        'terminal_id',

        'opened_by',
        'closed_by',

        'opening_balance',

        'cash_sales',
        'cash_in',
        'cash_out',
        'cash_refunds',

        'expected_balance',
        'actual_balance',
        'variance',

        'status',

        'opened_at',
        'closed_at',

        'opening_remarks',
        'closing_remarks',

    ];

    /*
    |--------------------------------------------------------------------------
    | Casts
    |--------------------------------------------------------------------------
    */

    protected $casts = [

        'opening_balance' => 'decimal:2',

        'cash_sales' => 'decimal:2',
        'cash_in' => 'decimal:2',
        'cash_out' => 'decimal:2',
        'cash_refunds' => 'decimal:2',

        'expected_balance' => 'decimal:2',
        'actual_balance' => 'decimal:2',
        'variance' => 'decimal:2',

        'opened_at' => 'datetime',
        'closed_at' => 'datetime',

    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function company(): BelongsTo
    {
        return $this->belongsTo(
            Company::class
        );
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(
            Branch::class
        );
    }

    public function terminal(): BelongsTo
    {
        return $this->belongsTo(
            Terminal::class
        );
    }

    public function openedBy(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'opened_by'
        );
    }

    public function closedBy(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'closed_by'
        );
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(
            CashDrawerTransaction::class
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeOpen($query)
    {
        return $query->where(
            'status',
            'Open'
        );
    }

    public function scopeClosed($query)
    {
        return $query->where(
            'status',
            'Closed'
        );
    }
}