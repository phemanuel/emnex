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

        'suffix',

        'separator',

        'current_number',

        'number_length',

        'reset_frequency',

        'last_reset_at',

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

            'company_id'      => 'integer',

            'current_number'  => 'integer',

            'number_length'   => 'integer',

            'last_reset_at'   => 'datetime',

            'status'          => 'boolean',

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

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', true);
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
        $number = str_pad(
            $this->current_number,
            $this->number_length,
            '0',
            STR_PAD_LEFT
        );

        return collect([
            $this->prefix,
            $number . ($this->suffix ?? ''),
        ])
        ->filter()
        ->implode($this->separator);
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
        $number = $this->formattedNumber(
            $this->current_number
        );

        $this->increment('current_number');

        $this->refresh();

        return $number;
    }

    public function formattedNumber(int $number): string
    {
        return
            $this->prefix
            . $this->separator
            . str_pad(
                $number,
                $this->number_length,
                '0',
                STR_PAD_LEFT
            )
            . ($this->suffix ?? '');
    }

    public function shouldReset(): bool
    {
        // Reset logic will be implemented
        // when integrating with POS, Sales,
        // and Purchasing modules.

        return false;
    }

    /**
     * Determine if the sequence is enabled.
     */
    public function isEnabled(): bool
    {
        return $this->status;
    }

    
}