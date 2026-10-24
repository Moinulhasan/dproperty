<?php

namespace App\Models\Concerns;

use App\Services\SiteData;

/**
 * For models shown on public pages: any save/delete drops the SiteData cache
 * and the guest full-page cache so visitors never see stale content.
 * (Mass updates via query builder bypass model events and are not covered.)
 */
trait FlushesSiteCache
{
    public static function bootFlushesSiteCache(): void
    {
        static::saved(fn () => SiteData::flush());
        static::deleted(fn () => SiteData::flush());
    }
}
