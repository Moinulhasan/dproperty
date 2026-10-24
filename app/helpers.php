<?php

use App\Services\ThumbnailService;
use Illuminate\Support\Str;

if (!function_exists('thumb')) {
    /**
     * URL of the WebP thumbnail for an image, falling back to the original
     * when the thumbnail has not been generated. Accepts a public-relative
     * path ("uploads/property/a.jpg") or a URL produced by asset().
     * Foreign URLs (e.g. Unsplash placeholders) are returned unchanged.
     */
    function thumb(?string $path, int $w = 480): string
    {
        if (!$path) {
            return asset('images/logo_main.png');
        }

        $base = asset('');
        if (Str::startsWith($path, ['http://', 'https://', '//'])) {
            if (!Str::startsWith($path, $base)) {
                return $path;
            }
            $path = Str::after($path, $base);
        }

        $path = ltrim($path, '/');
        $thumb = ThumbnailService::thumbPath($path, $w);

        return asset(is_file(public_path($thumb)) ? $thumb : $path);
    }
}
