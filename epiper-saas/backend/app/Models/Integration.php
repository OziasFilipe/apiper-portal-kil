<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Integration extends Model
{
    protected $fillable = [
        'name',
        'type',
        'provider',
        'status',
        'config',
        'credentials',
        'last_sync_at',
    ];

    protected $hidden = [
        'credentials',
    ];

    protected $casts = [
        'status' => 'boolean',
        'config' => 'array',
        'credentials' => 'array',
        'last_sync_at' => 'datetime',
    ];

    public function synchronizations()
    {
        return $this->hasMany(Synchronization::class);
    }
}
