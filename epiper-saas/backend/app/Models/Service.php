<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Service extends Model
{
    protected $fillable = [
        'name',
        'description',
        'status',
        'client_id',
        'company_id',
        'server_id',
        'product_id',
        'price',
        'starts_at',
        'ends_at',
        'notes',
    ];

    protected $casts = [
        'status' => 'boolean',
        'price' => 'decimal:2',
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function server()
    {
        return $this->belongsTo(Server::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
