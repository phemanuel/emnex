<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * ActivityLog Model
 *
 * Records all user activities within the system.
 */
class ActivityLog extends Model
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
        'user_id',

        'module',
        'action',
        'description',

        'record_type',
        'record_id',

        'old_values',
        'new_values',

        'url',
        'method',

        'ip_address',
        'user_agent',

        'browser',
        'platform',
        'device',
    ];

    /*
    |--------------------------------------------------------------------------
    | Casts
    |--------------------------------------------------------------------------
    */

    protected function casts(): array
    {
        return [

            'company_id'  => 'integer',

            'branch_id'   => 'integer',

            'terminal_id' => 'integer',

            'user_id'     => 'integer',

            'record_id'   => 'integer',

            'old_values'  => 'array',

            'new_values'  => 'array',

            'created_at'  => 'datetime',

            'updated_at'  => 'datetime',

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
     * Branch
     */
    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    /**
     * Terminal
     */
    public function terminal(): BelongsTo
    {
        return $this->belongsTo(Terminal::class, 'terminal_id');
    }

    /**
     * User
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Query Scopes
    |--------------------------------------------------------------------------
    */

    /**
     * Filter by module.
     */
    public function scopeModule(Builder $query, string $module): Builder
    {
        return $query->where('module', $module);
    }

    /**
     * Filter by action.
     */
    public function scopeAction(Builder $query, string $action): Builder
    {
        return $query->where('action', $action);
    }

    /**
     * Filter by user.
     */
    public function scopeUser(Builder $query, int $userId): Builder
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Filter by branch.
     */
    public function scopeBranch(
        Builder $query,
        int $branchId
    ): Builder {

        return $query->where(
            'branch_id',
            $branchId
        );

    }

    /**
     * Filter by terminal.
     */
    public function scopeTerminal(
        Builder $query,
        int $terminalId
    ): Builder {

        return $query->where(
            'terminal_id',
            $terminalId
        );

    }

    /**
     * Filter by date range.
     */
    public function scopeDateBetween(
        Builder $query,
        $from,
        $to
    ): Builder {

        return $query
            ->when($from, fn ($q) =>
                $q->whereDate(
                    'created_at',
                    '>=',
                    $from
                )
            )
            ->when($to, fn ($q) =>
                $q->whereDate(
                    'created_at',
                    '<=',
                    $to
                )
            );

    }

    /**
     * Search logs.
     */
    public function scopeSearch(
        Builder $query,
        ?string $search
    ): Builder {

        return $query->when(

            $search,

            function ($query) use ($search) {

                $query->where(function ($q) use ($search) {

                    $q->where(
                        'module',
                        'like',
                        "%{$search}%"
                    )

                    ->orWhere(
                        'action',
                        'like',
                        "%{$search}%"
                    )

                    ->orWhere(
                        'description',
                        'like',
                        "%{$search}%"
                    );

                });

            }

        );

    }

    /*
    |--------------------------------------------------------------------------
    | Helper Methods
    |--------------------------------------------------------------------------
    */

    /**
     * Check if activity belongs to a module.
     */
    public function isModule(string $module): bool
    {
        return strtolower($this->module) === strtolower($module);
    }

    /**
     * Check if activity matches an action.
     */
    public function isAction(string $action): bool
    {
        return strtolower($this->action) === strtolower($action);
    }

    public function getBadgeClassAttribute(): string
    {
        return match ($this->action) {

            'Created' => 'success',

            'Updated' => 'primary',

            'Deleted' => 'danger',

            'Enabled' => 'success',

            'Disabled' => 'warning',

            default => 'secondary',

        };
    }
}