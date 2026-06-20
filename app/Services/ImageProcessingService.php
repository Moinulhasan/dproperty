<?php

namespace App\Services;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ImageProcessingService
{
    protected ImageManager $manager;

    public function __construct()
    {
        $this->manager = new ImageManager(new Driver());
    }

    /**
     * Process an image: compress (and optionally stamp a watermark).
     *
     * @param string      $sourcePath Uploaded image path.
     * @param string      $targetPath Where to save the processed image.
     * @param int         $quality    JPEG/WebP quality (default 75).
     * @param string|null $logoPath   Absolute path of the watermark logo. When
     *                                null or unreadable, NO watermark is applied
     *                                — that's the documented "skip silently"
     *                                fallback when a property has no company
     *                                logo to stamp.
     */
    public function process(string $sourcePath, string $targetPath, int $quality = 75, ?string $logoPath = null): string
    {
        try {
            $image = $this->manager->read($sourcePath);

            if ($image->width() > 1920) {
                $image->scale(width: 1920);
            }

            if ($logoPath && file_exists($logoPath)) {
                $logo = $this->manager->read($logoPath);

                // Watermark bounding box: ~35% of image width / ~25% of
                // image height, capped at 600×360 px so it stays prominent
                // on phone-sized images and doesn't go huge on 4K shots.
                // scaleDown only shrinks (never enlarges) and preserves the
                // logo's aspect ratio, so a square / portrait logo doesn't
                // get stretched. Tuned bigger than the previous 18% / 280×140
                // for better brand visibility.
                $maxWidth  = min(600, (int) ($image->width()  * 0.35));
                $maxHeight = min(360, (int) ($image->height() * 0.25));
                $logo->scaleDown(width: $maxWidth, height: $maxHeight);

                // place(image, position, x-offset, y-offset, opacity-percent)
                $image->place($logo, 'center', 0, 0, 30);
            }

            $image->save($targetPath, quality: $quality);

            return $targetPath;
        } catch (\Exception $e) {
            if ($sourcePath !== $targetPath && !file_exists($targetPath)) {
                rename($sourcePath, $targetPath);
            }
            throw $e;
        }
    }
}
