<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    protected $fillable = [
        'company_id',
        'token',
        'used',
        'expired_at',
    ];

    protected $casts = [
        'used' => 'boolean',
        'expired_at' => 'datetime',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function isExpired()
    {
        return $this->expired_at && $this->expired_at->isPast();
    }
}
