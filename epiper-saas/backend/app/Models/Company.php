<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    protected $fillable = [
        'name',
        'trade_name',
        'document',
        'email',
        'phone',
        'address',
        'city',
        'state',
        'zip_code',
        'status',
        'logo',
        'settings',
    ];

    protected $casts = [
        'status' => 'boolean',
        'settings' => 'array',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function clients()
    {
        return $this->hasMany(Client::class);
    }

    public function servers()
    {
        return $this->hasMany(Server::class);
    }
}
