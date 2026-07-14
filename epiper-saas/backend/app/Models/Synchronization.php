<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Synchronization extends Model
{
    protected $fillable = [
        'name',
        'type',
        'status',
        'integration_id',
        'server_id',
        'company_id',
        'last_run_at',
        'next_run_at',
        'schedule',
        'logs',
        'error_message',
    ];

    protected $casts = [
        'status' => 'boolean',
        'last_run_at' => 'datetime',
        'next_run_at' => 'datetime',
        'logs' => 'array',
    ];

    public function integration()
    {
        return $this->belongsTo(Integration::class);
    }

    public function server()
    {
        return $this->belongsTo(Server::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
