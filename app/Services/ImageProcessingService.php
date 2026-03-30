<?php

namespace App\Services;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ImageProcessingService
{
    protected string $logoPath;
    protected ImageManager $manager;

    public function __construct()
    {
        $this->logoPath = public_path('images/logo_main.png');
        $this->manager = new ImageManager(new Driver());
    }

    /**
     * Process an image: compress and add watermark.
     *
     * @param string $sourcePath Path to the uploaded image.
     * @param string $targetPath Path where to save the processed image.
     * @param int $quality Quality level for compression (default 75).
     * @return string Relative path to the processed image.
     */
    public function process(string $sourcePath, string $targetPath, int $quality = 75): string
    {
        try {
            $image = $this->manager->read($sourcePath);

            // 1. Resize if too large to help with compression (e.g. max width 1920)
            if ($image->width() > 1920) {
                $image->scale(width: 1920);
            }

            // 2. Add Watermark Logo
            if (file_exists($this->logoPath)) {
                $logo = $this->manager->read($this->logoPath);

                // Scale logo to 20% of image width
                $logoWidth = (int)($image->width() * 0.2);
                $logo->scale(width: $logoWidth);

                // Place logo at bottom-right with padding
                $image->place($logo, 'top-left', 20, 20);
            }

            // 3. Save and Compress (Quality 75 by default to reach ~200KB target)
            $image->save($targetPath, quality: $quality);

            return $targetPath;
        } catch (\Exception $e) {
            // Fallback: move file if processing fails or log error
            if ($sourcePath !== $targetPath && !file_exists($targetPath)) {
                rename($sourcePath, $targetPath);
            }
            throw $e;
        }
    }
}
