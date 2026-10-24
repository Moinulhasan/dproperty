<?php

namespace App\Http\CacheProfiles;

use Illuminate\Http\Request;
use Spatie\ResponseCache\CacheProfiles\CacheAllSuccessfulGetRequests;

/**
 * Full-page cache for guests only: signed-in users (admins) always get a
 * fresh page and never populate the cache. URLs with a query string are not
 * cached: each distinct one (e.g. Facebook's per-click ?fbclid=) would be a
 * new ~400 KB file that the file cache never cleans up.
 */
class GuestPages extends CacheAllSuccessfulGetRequests
{
    public function shouldCacheRequest(Request $request): bool
    {
        return !auth()->check()
            && $request->getQueryString() === null
            && parent::shouldCacheRequest($request);
    }
}
