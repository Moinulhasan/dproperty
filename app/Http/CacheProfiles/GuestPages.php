<?php

namespace App\Http\CacheProfiles;

use Illuminate\Http\Request;
use Spatie\ResponseCache\CacheProfiles\CacheAllSuccessfulGetRequests;

/**
 * Full-page cache for guests only: signed-in users (admins) always get a
 * fresh page and never populate the cache.
 */
class GuestPages extends CacheAllSuccessfulGetRequests
{
    public function shouldCacheRequest(Request $request): bool
    {
        return !auth()->check() && parent::shouldCacheRequest($request);
    }
}
