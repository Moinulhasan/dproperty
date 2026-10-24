<?php

namespace App\Models;

use App\Models\Concerns\FlushesSiteCache;
use Illuminate\Database\Eloquent\Model;

class PropertyDetailValue extends Model
{
    use FlushesSiteCache;

    protected $guarded = [];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function detail()
    {
        return $this->belongsTo(PropertyDetail::class, 'property_detail_id');
    }
}
