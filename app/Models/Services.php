<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Services extends Model
{
    //
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getImageAttribute($value)
    {
        if (!$value) {
            return null;
        }
        // Pass full URLs through untouched (e.g., seeded Unsplash images).
        // Otherwise treat the value as a relative path inside public/storage.
        if (str_starts_with($value, 'http://') || str_starts_with($value, 'https://')) {
            return $value;
        }
        return asset('storage/' . $value);
    }
}
