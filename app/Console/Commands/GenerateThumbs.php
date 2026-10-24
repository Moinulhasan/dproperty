<?php

namespace App\Console\Commands;

use App\Services\ThumbnailService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class GenerateThumbs extends Command
{
    protected $signature = 'images:thumbs {dir=uploads/property : Folder relative to public/}
                            {--force : Regenerate existing thumbnails}
                            {--sizes= : Comma list of width:quality, e.g. 1280:75,1920:75 (default 480:70,960:72)}';

    protected $description = 'Generate WebP thumbnails for every image in a public folder (originals untouched)';

    public function handle(ThumbnailService $thumbs): int
    {
        ini_set('memory_limit', '512M');

        $dir = public_path(trim($this->argument('dir'), '/'));
        if (!is_dir($dir)) {
            $this->error("Folder not found: {$dir}");
            return self::FAILURE;
        }

        $sizes = ThumbnailService::SIZES;
        if ($this->option('sizes')) {
            $sizes = [];
            foreach (explode(',', $this->option('sizes')) as $pair) {
                [$w, $q] = array_pad(explode(':', $pair), 2, 75);
                $sizes[(int) $w] = (int) $q;
            }
        }

        // Top level only, so thumbs/ subfolders are never re-processed.
        $files = glob($dir . '/*.{jpg,jpeg,png,webp,JPG,JPEG,PNG,WEBP}', GLOB_BRACE) ?: [];
        $failed = 0;

        $this->withProgressBar($files, function (string $file) use ($thumbs, $sizes, &$failed) {
            try {
                $thumbs->make($file, (bool) $this->option('force'), $sizes);
            } catch (\Throwable $e) {
                $failed++;
                Log::warning("images:thumbs failed for {$file}: {$e->getMessage()}");
            }
        });

        $this->newLine();
        $this->info(count($files) . " images processed, {$failed} failed (see log).");

        return self::SUCCESS;
    }
}
