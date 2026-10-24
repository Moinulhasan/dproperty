<?php

namespace App\Models;

use App\Models\Concerns\FlushesSiteCache;
use App\Services\ThumbnailService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HomeSlider extends Model
{
    use FlushesSiteCache;

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

    /**
     * srcset for the hero <img>: WebP thumbnails smaller than the original,
     * then the original itself at its real width (phones crop the `cover`
     * hero by height and need full resolution). Falls back to the original.
     */
    public function heroSrcset(): string
    {
        $path = 'storage/' . $this->attributes['image'];
        $width = @getimagesize(public_path($path))[0] ?? 0;
        if (!$width) {
            return asset($path);
        }

        $set = [];
        foreach (array_keys(ThumbnailService::HERO_SIZES) as $w) {
            $thumb = ThumbnailService::thumbPath($path, $w);
            if ($w < $width && is_file(public_path($thumb))) {
                $set[] = asset($thumb) . " {$w}w";
            }
        }
        $set[] = asset($path) . " {$width}w";

        return implode(', ', $set);
    }
}
