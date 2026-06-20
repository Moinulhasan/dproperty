<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyRequest extends Model
{
    protected $guarded = [];

    protected $casts = [
        'trade_license_expiry' => 'date',
        'reviewed_at'          => 'datetime',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
