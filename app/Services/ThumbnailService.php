<?php

namespace App\Services;

use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

/**
 * Generates resized WebP copies next to an original image, in
 * {dir}/thumbs/{width}/{filename}.webp. Originals are never touched.
 */
class ThumbnailService
{
    /** Card / general images: width => WebP quality. */
    public const SIZES = [480 => 70, 960 => 72];

    /** Hero slider images (the original is the srcset's top candidate). */
    public const HERO_SIZES = [1280 => 75, 1920 => 75];

    /** Site logo, shown at 120×40 (240 covers 2× screens). */
    public const LOGO_SIZES = [240 => 80];

    protected ImageManager $manager;

    public function __construct()
    {
        $this->manager = new ImageManager(new Driver());
    }

    /**
     * @param array<int,int> $sizes width => quality
     */
    public function make(string $absPath, bool $force = false, array $sizes = self::SIZES): void
    {
        // Largest first, each size resized from the previous one: one decode and
        // small later resizes (~40% faster than decoding per size; cloning the
        // full-size image instead was slower and doubled peak memory).
        krsort($sizes);
        $image = null;
        foreach ($sizes as $width => $quality) {
            $target = self::thumbPath($absPath, $width);
            if (!$force && is_file($target)) {
                continue;
            }
            if (!is_dir(dirname($target))) {
                mkdir(dirname($target), 0755, true);
            }
            $image ??= $this->manager->read($absPath);
            $image->scaleDown(width: $width);
            $image->toWebp($quality)->save($target);
        }
    }

    /**
     * Call right after an upload is saved. Never throws: a failed thumbnail
     * must not fail the upload, and thumb() falls back to the original.
     *
     * @param string         $path  path relative to public/ (e.g. "storage/slider/x.jpg")
     * @param array<int,int> $sizes width => quality
     */
    public static function forUpload(?string $path, array $sizes = self::SIZES): void
    {
        if ($path) {
            rescue(fn () => app(self::class)->make(public_path($path), true, $sizes), report: true);
        }
    }

    /** Same layout for absolute and public-relative paths. */
    public static function thumbPath(string $path, int $width): string
    {
        $info = pathinfo($path);
        $dir = $info['dirname'] === '.' ? '' : $info['dirname'] . '/';

        return "{$dir}thumbs/{$width}/{$info['filename']}.webp";
    }
}
