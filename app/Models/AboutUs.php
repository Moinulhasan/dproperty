<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutUs extends Model
{
    protected $guarded = [];

    /**
     * Natural [width, height] of the image, for width/height attributes so the
     * browser reserves its space before it loads (no layout shift). Null if
     * the file is missing or unreadable.
     */
    public function imageSize(): ?array
    {
        $size = $this->image ? @getimagesize(public_path($this->image)) : false;

        return $size ? [$size[0], $size[1]] : null;
    }
}
