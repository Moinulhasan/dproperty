<?php

namespace App\Models;

use App\Models\Concerns\FlushesSiteCache;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use FlushesSiteCache;

    protected $guarded = [];

    public function properties()
    {
        return $this->hasMany(Property::class);
    }
}
