<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropertyDetailValue extends Model
{
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
