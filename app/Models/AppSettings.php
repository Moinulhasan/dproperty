<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppSettings extends Model
{
    //
    protected $guarded = [];

    public function getLogoAttribute($value)
    {
        return asset('storage/' . $value ?? 'logo.png');
    }

    public function getFaviconAttribute($value)
    {
        return asset('storage/' . $value ?? 'favicon.png');
    }

    public function getContactImageAttribute($image)
    {
        return asset('storage/' . $image ?? 'images/why_us.svg');
    }
}
