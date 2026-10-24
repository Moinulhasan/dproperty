<?php

namespace Tests\Feature;

use App\Services\ThumbnailService;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class ThumbnailTest extends TestCase
{
    private string $dir = 'uploads/_thumb_test';

    protected function tearDown(): void
    {
        File::deleteDirectory(public_path($this->dir));
        parent::tearDown();
    }

    public function test_thumb_falls_back_to_original_until_generated_then_serves_webp(): void
    {
        File::ensureDirectoryExists(public_path($this->dir));
        $original = "{$this->dir}/photo.jpg";
        imagejpeg(imagecreatetruecolor(1200, 600), public_path($original));

        $this->assertSame(asset($original), thumb($original));
        $this->assertSame(asset($original), thumb(asset($original), 960));

        app(ThumbnailService::class)->make(public_path($original));

        $this->assertSame(asset("{$this->dir}/thumbs/480/photo.webp"), thumb($original));
        $this->assertSame(asset("{$this->dir}/thumbs/960/photo.webp"), thumb(asset($original), 960));
        $this->assertSame(480, getimagesize(public_path("{$this->dir}/thumbs/480/photo.webp"))[0]);
        // 960 must come from the full original, not from the already-shrunk 480 copy
        $this->assertSame(960, getimagesize(public_path("{$this->dir}/thumbs/960/photo.webp"))[0]);
        $this->assertFileExists(public_path($original), 'original must never be touched');
    }

    public function test_thumb_passes_foreign_urls_through_and_handles_null(): void
    {
        $this->assertSame('https://images.unsplash.com/x.jpg', thumb('https://images.unsplash.com/x.jpg'));
        $this->assertSame(asset('images/logo_main.png'), thumb(null));
    }

    public function test_for_upload_never_throws_on_a_bad_file(): void
    {
        ThumbnailService::forUpload("{$this->dir}/missing.jpg");
        $this->assertTrue(true);
    }
}
