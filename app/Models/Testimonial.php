<?php

namespace App\Models;

use App\Models\Concerns\FlushesSiteCache;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use FlushesSiteCache;

    //
    protected $guarded = [];

    public function getImageAttribute($value)
    {
        return asset('storage/' . $value);
    }
}
