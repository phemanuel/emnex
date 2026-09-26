<?php

// app/Models/SyncDevice.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SyncDevice extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'branch_id',
        'terminal_id',
        'device_uuid',
        'device_name',
        'device_type',
        'app_version',
        'database_version',
        'sync_token_hash',
        'token_created_at',
        'is_active',
        'last_seen_at',
        'last_sync_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'token_created_at' => 'datetime',
        'last_seen_at' => 'datetime',
        'last_sync_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function terminal(): BelongsTo
    {
        return $this->belongsTo(Terminal::class);
    }

    public function syncQueue(): HasMany
    {
        return $this->hasMany(SyncQueue::class, 'device_id');
    }

    public function syncLogs(): HasMany
    {
        return $this->hasMany(SyncLog::class, 'device_id');
    }
}
