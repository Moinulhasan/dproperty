<?php

namespace Tests\Feature;

use App\Models\Amenity;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Spatie\ResponseCache\Facades\ResponseCache;
use Tests\TestCase;

/**
 * Public pages are served from caches (SiteData + guest page cache), so any
 * admin save or delete must clear them, or visitors see stale content.
 * SQLite in-memory (phpunit.xml): never touches the production database.
 */
class SiteCacheTest extends TestCase
{
    use RefreshDatabase;

    public function test_saving_and_deleting_content_clears_site_and_page_caches(): void
    {
        ResponseCache::spy();
        Cache::put('site.locations', 'stale', 3600);

        $amenity = Amenity::create(['name' => 'Gym']);

        $this->assertFalse(Cache::has('site.locations'), 'save must drop SiteData keys');
        ResponseCache::shouldHaveReceived('clear')->once();

        Cache::put('site.locations', 'stale', 3600);
        $amenity->delete();

        $this->assertFalse(Cache::has('site.locations'), 'delete must drop SiteData keys');
        ResponseCache::shouldHaveReceived('clear')->twice();
    }
}
