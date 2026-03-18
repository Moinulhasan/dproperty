<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropertyDetail extends Model
{
    protected $guarded = [];

    protected $casts = [
        'options' => 'array',
    ];

    public function values()
    {
        return $this->hasMany(PropertyDetailValue::class);
    }
}
