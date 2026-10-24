# dproperty: performance and security work log

What was changed, why, how it was verified, and what is still open.
Branch `performance`. Work done 2026-10-24.

Related docs:
- `CLAUDE.md` is the original 8-phase brief.
- `deployment-performance.md` covers server requirements, Nginx and OPcache.
- `deployment-cpanel.md` is the cPanel runbook used to deploy.

| Commit | Contents |
|---|---|
| `fa302de` | Performance phases 1–8 |
| `93398a1` | Security "must fix" patch (findings 1–6) |

---

## 1. Facts about this environment (read first)

- **The local `.env` points at the live production database** (`DB_HOST=103.112.62.56`,
  `DB_DATABASE=dpropert_live`). Any migration, tinker write, or test run against MySQL
  changes live data. The test suite is safe: `phpunit.xml` forces SQLite in memory.
- A migration named `create_about_us_table` is **pending** although the table exists.
  Never run a plain `php artisan migrate`; run new migrations with `--path=...`.
- The site sits **behind Cloudflare** (the domain resolves to Cloudflare IPs).
- Hosting is **shared cPanel** with terminal access; deploys are done by **zip upload**.
- Local XAMPP changes made during the work: `extension=gd` was enabled in
  `C:\xampp\php\php.ini`, and the local `.env` has `SESSION_DRIVER=file` and `CACHE_STORE=file`.
- Git has no global author identity on this PC; commits were made by the owner.

---

## 2. Results

Homepage, compared with the baseline in `CLAUDE.md`.

| Metric | Before | After |
|---|---|---|
| Page weight | 31.8 MB | ~0.8 MB desktop / ~1.3 MB mobile (with gzip) |
| Requests | 250 | ~24 |
| `<img>` tags | 688 | 47 |
| HTML | 500 KB | 25 KB gzip |
| Render-blocking CSS | 13 files | 2 |
| DB queries | 35 | 16 fully cold, 7 with warm data cache, 0 from page cache |
| Server time (TTFB) | 678 ms | 8–16 ms cached (OPcache + `optimize`) |
| CLS | 0.002 | 0–0.003 |
| DOM nodes | 4,265 | ~2,580 (owner chose to keep 20 rent + 20 sale cards) |
| Lighthouse mobile | 38 (live, old code) | 65 production-like (gzip, no Debugbar) |

Visual check: every page is pixel-identical apart from image resampling noise. Section
positions match to the pixel. Visible text matches line by line on home, rent, location,
detail, blog and about-us. Card bed/bath values (93 items) are identical.

---

## 3. What was done, phase by phase

### Phase 1: Quick wins
- Swiper from the unpinned `freeps2/a7rarpress@main` GitHub repo was verified
  byte-identical to Swiper 8.1.6 and replaced. That repo's `script.js` returned 404 and
  was removed.
- Layout scripts got `defer`. All inline scripts already waited for `DOMContentLoaded`.
- `config/debugbar.php`: Debugbar is never enabled outside `APP_ENV=local`.

### Phase 2: Image thumbnails
- `app/Services/ThumbnailService.php` writes WebP copies to `{dir}/thumbs/{width}/{name}.webp`:
  `SIZES` 480/960, `HERO_SIZES` 1280/1920, `LOGO_SIZES` 240. Originals are never touched.
  `forUpload()` never throws.
- `app/Console/Commands/GenerateThumbs.php`: `php artisan images:thumbs {dir} {--force} {--sizes=}`.
- `app/helpers.php` provides `thumb($path, $w = 480)`. It falls back to the original when
  no thumbnail exists, passes external URLs through, and returns a placeholder for null.
  Autoloaded through `composer.json`.
- Every admin upload (properties, sliders, logo, contact image, testimonials, locations,
  articles) calls `ThumbnailService::forUpload()`.
- `resources/views/component/_card_img.blade.php` is the shared card image tag (`srcset`/`sizes`).
- Logo: 240 px WebP with `width="120" height="40"`. Both logos are forced to 40 px by CSS.

### Phase 3: Sliders and DOM
- Card slides after the first are wrapped in `<template>`. The images are created on the
  first hover, touch or focus of the card (handler in `resources/js/site.js`).
- Section sliders use `rewind` instead of `loop`, **except sections with ≤4 cards**. Those
  keep `loop` because For Sell has 3 cards and loop filled the 4th desktop slot with a clone.
- Sliders start when near the viewport through `window.whenNear(el, fn)`
  (IntersectionObserver, 200 px margin).
- Removed duplicate Swiper creation on the featured, listing and detail pages.
- Reserved the select2 field height (`min-height: 54px`) so the search bar no longer shifts.

### Phase 4: Hero / LCP
- The hero `background-image` became `<img class="hero-slide-img">` with `object-fit: cover`.
  The first slide has `fetchpriority="high"`, and the homepage preloads it.
- `HomeSlider::heroSrcset()` offers WebP 1280/1920 plus the original at its real width.
  Phones get the original, because a cover-cropped hero needs full resolution to look identical.

### Phase 5: Vite bundles
- Entries are listed in `vite.config.js`. `resources/css/site.css` imports, in the original
  `<link>` order: self-hosted Inter (`resources/css/fonts.css`, `resources/fonts/inter`),
  Bootstrap 5.3.0, Bootstrap Icons 1.10.0, `main.css`, Swiper 8.1.6, site CSS, and Font Awesome 5.15.4.
- `resources/css/listings.css` bundles select2 + `listings.css` + `property_cards.css`
  for the listing and location pages.
- `resources/js/site.js` sets the globals `$`, `jQuery`, `bootstrap`, `Swiper`, `whenNear`
  and `openGallery`. Fancybox is loaded on demand with `import()`.
- Page scripts live in `resources/js/pages/*.js` and `resources/js/home/*.js`. Blade values
  are passed through `data-` attributes.
- All npm packages were pinned to the exact CDN versions and verified byte-identical.
  Tailwind was removed from the Vite config; it was unused.
- `public/build/` is git-ignored, so run `npm run build` before every deploy.

### Phase 6: Backend
- `app/Services/SiteData.php` caches settings, locations, categories, testimonials,
  sliders, tags and id maps for one hour, memoised per request with `once()`.
- `app/Models/Concerns/FlushesSiteCache.php` is on the public-facing models. Saves and
  deletes clear the SiteData cache and the page cache. Mass query-builder updates are not covered.
- Guest homepage page cache: `spatie/laravel-responsecache`, 10 min, profile
  `app/Http/CacheProfiles/GuestPages.php`. Guests only, and no query strings.
- `Property::scopeForCard()` selects only the card columns, and `Property::loadCardRelations()`
  loads detail values **per section with the original unfiltered query**. The bed/bath value
  on a card depends on the order MySQL returns rows in. That order depends on the query plan,
  so changing the query's shape changed what cards displayed.
- Migration `2026_10_24_000000_add_homepage_indexes_to_properties_table` adds two composite
  indexes on `properties`. **Already applied to the live database.**
- Removed the neighbourhood N+1 count (it wasn't displayed) and the per-slide `HomeSlider::first()` query.

### Phase 7: Perceived speed
- `master.blade.php` has speculation rules that prerender property pages (including
  `target="_blank"` links) and listing pages on hover.
- `resources/css/transitions.css` adds a 200 ms cross-document fade, disabled for reduced motion.
- Skipped on purpose: section-by-section `fetch()` loading (layout-shift and SEO risk)
  and Livewire (not needed).

### Phase 8: Motion
- `motion@14.1.0` animates below-the-fold card rows (fade plus 20 px rise). Inline styles
  are removed afterwards. Off for reduced motion. Smooth scroll also respects reduced motion.

---

## 4. Security patch (commit `93398a1`)

| # | Problem | Fix |
|---|---|---|
| 1 | Company-register uploads kept the visitor's extension. A `.pht` or `.html` file with image content passed validation and was served from `public/uploads`. Laravel already blocks `.php`. | `$file->hashName()` names the file from its real content. `public/uploads/.htaccess` and `storage/app/public/.htaccess` deny script files. |
| 2 | No limits on public forms: 30 MB of uploads per company submission could fill the disk. | `throttle:5,1` on contact, post-property and company-register; `message` capped at 5,000 characters. |
| 3 | Unlimited admin login attempts. | `throttle:5,1` on `/admin/post-login`. |
| 4 | Admin deletes were GET links, so any page could trigger them with the admin's cookie. | 18 delete routes are now `DELETE` and logout is `POST`. A handler in `resources/views/admin/master.blade.php` sends the existing links as CSRF forms after `confirm()`. |
| 5 | Editing a property deleted the old photo before the new one was saved. | Old files are deleted only after `$property->update()` succeeds. |
| 6 | The page cache stored a ~435 KB file per query string (Facebook `?fbclid=` on every click). | Query-string URLs are not cached. |

Also added: `$middleware->trustProxies(at: '*')` in `bootstrap/app.php`. Behind Cloudflare,
this makes rate limits apply per visitor instead of per Cloudflare server.

Tests: `tests/Feature/SecurityFixesTest.php` (5 tests) and `tests/Feature/ThumbnailTest.php` (3 tests).
The upload test was confirmed to fail on the old code. Only the old `ExampleTest` fails,
because it has no tables in SQLite; it failed before this work too.

**Deploy note:** the zip method excludes `public/uploads` and `storage/app/public`. Copy the
two `.htaccess` files to the server by hand.

---

## 5. Open items

### Audit findings not fixed yet ("should fix")
- **7. Permissions:** any logged-in staff account is effectively a full admin. Roles,
  permissions and app settings aren't checked, and `{!! !!}` on property description and
  `map_link` lets staff add scripts to public pages. Fix: `role:Super Admin` middleware on
  those route groups.
- ~~**8. Capacity**~~ **Done in code:** the guest page cache now also covers
  `property-details/{id}`, `/buy`, `/sell`, `/rent` and `/location/{id}` (plain URLs only;
  filters and pagination render fresh). `Company`, `Amenity` and `TermsCondition` now clear
  the caches too. Test: `tests/Feature/SiteCacheTest.php`. **Server side still to do:** the
  Cloudflare rate limit rule and the daily `responsecache:clear` cron (both in
  `deployment-cpanel.md`).
- **9. Session files (server setting):** keep `file`. Check
  `ls storage/framework/sessions | wc -l` now and then; above ~100k, switch to `database`
  (runbook 4a).
- **10. Logging (server setting):** set `LOG_STACK=daily`, `LOG_DAILY_DAYS=14` and
  `LOG_LEVEL=warning` in the production `.env` (runbook 4a).
- ~~**11. Error leak**~~ **Done:** the company form logs the exception and shows visitors a
  generic message. Admin screens still show error details to staff, on purpose.
- **12. Local DB:** the local PC is connected to the live database. Use a local copy.
- **13. Tests:** permission checks have no tests.
- ~~**14. Thumbnails**~~ **Done:** `ThumbnailService::make()` decodes once and resizes largest
  first, each size from the previous (~40% faster, same peak memory; 480 px output within
  0.8% of a direct resize). Cloning the full-size image was tried first: slower and 2.4× the memory.

### Lighthouse 65 → ~90 (not started)
1. A centre-cropped WebP of the mobile hero (227 KB → ~70 KB, identical pixels).
2. A 720 px thumbnail size and correct `sizes` for cards and neighbourhoods.
3. Delay far-below-the-fold images until near the viewport.
4. A subset of the Bootstrap Icons font (118 KB → ~3 KB). Needs a font-subsetting tool.
5. Critical CSS or PurgeCSS. Biggest first-paint gain and highest visual risk.
6. Import only the Swiper and Bootstrap modules actually used.

### Owner decisions pending
- Production `SESSION_DRIVER` / `CACHE_STORE` from database to file (switching logs everyone out once).

---

## 6. Lessons from this work

- Measure first and keep a baseline (numbers and screenshots), so every change can be compared.
- The visual comparison baseline must serve real images. A first baseline without uploads
  hid real differences.
- Pages that paint sooner reveal layout shifts that were always there. Reserve the final size.
- Code that depends on unspecified row order (MySQL plan-dependent) breaks when queries
  are "optimised". Keep the original query or make the order explicit.
- Check `DB_HOST` before any write. Look inside a folder before deleting it.
- Use the tool the client uses: Lighthouse simulates a much slower phone than ad-hoc tests.
- Laravel's `mimes`/`image` rules check content and block `.php` names, but the saved
  extension must still come from content (`hashName()`).
