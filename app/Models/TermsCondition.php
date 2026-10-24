<?php

namespace App\Models;

use App\Models\Concerns\FlushesSiteCache;
use Illuminate\Database\Eloquent\Model;

class TermsCondition extends Model
{
    use FlushesSiteCache;

    protected $guarded = [];
}
