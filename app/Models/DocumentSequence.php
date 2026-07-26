<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * DocumentSequence Model
 *
 * Stores document numbering sequences for each company.
 */
class DocumentSequence extends Model
{
    use HasFactory;

    /*
    |--------------------------------------------------------------------------
    | Fillable
    |--------------------------------------------------------------------------
    */

    protected $fillable = [
        'company_id',
        'document_type',
        'prefix',
        'current_number',
        'number_length',
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
            'current_number' => 'integer',
            'number_length'  => 'integer',
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

    /*
    |--------------------------------------------------------------------------
    | Query Scopes
    |--------------------------------------------------------------------------
    */

    /**
     * Filter by document type.
     */
    public function scopeType(Builder $query, string $type): Builder
    {
        return $query->where('document_type', $type);
    }

    /*
    |--------------------------------------------------------------------------
    | Helper Methods
    |--------------------------------------------------------------------------
    */

    /**
     * Generate the next document number.
     *
     * Example:
     * ORD-000001
     */
    public function nextNumber(): string
    {
        return $this->prefix .
            str_pad(
                $this->current_number,
                $this->number_length,
                '0',
                STR_PAD_LEFT
            );
    }

    /**
     * Increment the sequence.
     */
    public function incrementSequence(): void
    {
        $this->increment('current_number');
    }

    /**
     * Generate the next number and increment the sequence.
     *
     * This should be the primary method used by the application.
     */
    public function generate(): string
    {
        $number = $this->nextNumber();

        $this->incrementSequence();

        return $number;
    }
}