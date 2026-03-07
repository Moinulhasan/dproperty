<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    protected $guarded = [];

    protected $casts = [
        'images' => 'array',
        'is_featured' => 'boolean',
        'is_home_featured' => 'boolean',
        'is_location_featured' => 'boolean',
    ];

    public function amenities()
    {
        return $this->belongsToMany(Amenity::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
