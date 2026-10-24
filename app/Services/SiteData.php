<?php

namespace App\Services;

use App\Models\AppSettings;
use App\Models\HomeSlider;
use App\Models\Location;
use App\Models\PropertyCategory;
use App\Models\PropertyDetail;
use App\Models\Tags;
use App\Models\Testimonial;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Spatie\ResponseCache\Facades\ResponseCache;

/**
 * Site-wide data read on (almost) every page, cached for an hour.
 * Every key is flushed by the FlushesSiteCache model trait on save/delete.
 */
class SiteData
{
    private const TTL = 3600;

    private const KEYS = [
        'site.settings', 'site.locations', 'site.categories', 'site.testimonials',
        'site.sliders', 'site.tags', 'site.locations_by_id', 'site.details_by_id',
    ];

    public static function settings(): ?AppSettings
    {
        return once(fn () => Cache::remember('site.settings', self::TTL, fn () => AppSettings::where('site_name', 'dproperty')->first()));
    }

    /** Active locations, admin order (search filters, footer, neighborhoods). */
    public static function locations(): Collection
    {
        return once(fn () => Cache::remember('site.locations', self::TTL, fn () => Location::where('status', 1)->orderBy('order')->orderBy('name')->get()));
    }

    /** Top-level categories with their children (search filters). */
    public static function categories(): Collection
    {
        return once(fn () => Cache::remember('site.categories', self::TTL, fn () => PropertyCategory::with('children')->whereNull('parent_id')->get()));
    }

    public static function testimonials(): Collection
    {
        return once(fn () => Cache::remember('site.testimonials', self::TTL, fn () => Testimonial::orderBy('order')->orderBy('created_at', 'desc')->where('status', 1)->get()));
    }

    public static function sliders(): Collection
    {
        return once(fn () => Cache::remember('site.sliders', self::TTL, fn () => HomeSlider::orderBy('created_at', 'desc')->where('status', 1)->get()));
    }

    public static function tags(): Collection
    {
        return once(fn () => Cache::remember('site.tags', self::TTL, fn () => Tags::where('status', 1)->get()));
    }

    /** Every location (active or not) by id, for card location names. */
    public static function locationsById(): Collection
    {
        return once(fn () => Cache::remember('site.locations_by_id', self::TTL, fn () => Location::all(['id', 'name'])->keyBy('id')));
    }

    /** Every property detail definition by id, for card bed/bath/area icons. */
    public static function detailsById(): Collection
    {
        return once(fn () => Cache::remember('site.details_by_id', self::TTL, fn () => PropertyDetail::all(['id', 'name', 'icon'])->keyBy('id')));
    }

    /** Drop every cached key and the guest page cache. */
    public static function flush(): void
    {
        foreach (self::KEYS as $key) {
            Cache::forget($key);
        }
        ResponseCache::clear();
    }
}
