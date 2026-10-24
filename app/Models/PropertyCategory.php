<?php

namespace App\Models;

use App\Models\Concerns\FlushesSiteCache;
use Illuminate\Database\Eloquent\Model;

class PropertyCategory extends Model
{
    use FlushesSiteCache;

    protected $guarded = [];
    protected $table = 'property_categories';

    public function parent()
    {
        return $this->belongsTo(PropertyCategory::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(PropertyCategory::class, 'parent_id')->where('status', 1);
    }

    public function properties()
    {
        return $this->hasMany(Property::class, 'property_category_id');
    }
}
