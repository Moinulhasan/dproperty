<?php

namespace App\Models;

use App\Models\Concerns\FlushesSiteCache;
use Illuminate\Database\Eloquent\Model;

class Tags extends Model
{
    use FlushesSiteCache;

    //
    protected $guarded=[];

}
