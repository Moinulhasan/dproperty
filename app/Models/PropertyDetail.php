<?php

namespace App\Models;

use App\Models\Concerns\FlushesSiteCache;
use Illuminate\Database\Eloquent\Model;

class PropertyDetail extends Model
{
    use FlushesSiteCache;

    protected $guarded = [];

    protected $casts = [
        'options' => 'array',
    ];

    public function values()
    {
        return $this->hasMany(PropertyDetailValue::class);
    }
}
