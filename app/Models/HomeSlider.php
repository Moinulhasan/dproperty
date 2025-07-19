<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HomeSlider extends Model
{
    //
    protected $guarded = [];

    public function user():belongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getImageAttribute(): string
    {
        return asset('storage/' . $this->attributes['image']);
    }
}
