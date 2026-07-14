<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Server extends Model
{
    protected $fillable = [
        'name',
        'host',
        'port',
        'username',
        'type',
        'status',
        'company_id',
        'user_id',
        'os',
        'cpu',
        'ram',
        'disk',
        'last_ping_at',
    ];

    protected $hidden = [
        'password',
        'private_key',
    ];

    protected $casts = [
        'status' => 'boolean',
        'last_ping_at' => 'datetime',
        'cpu' => 'float',
        'ram' => 'float',
        'disk' => 'float',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function services()
    {
        return $this->hasMany(Service::class);
    }

    public function synchronizations()
    {
        return $this->hasMany(Synchronization::class);
    }
}
