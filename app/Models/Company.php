<?php

namespace App\Models;

use App\Models\Concerns\FlushesSiteCache;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use FlushesSiteCache;

    protected $guarded = [];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function properties()
    {
        return $this->hasManyThrough(Property::class, User::class, 'company_id', 'created_by');
    }
}
