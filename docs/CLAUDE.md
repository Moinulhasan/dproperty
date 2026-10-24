# CLAUDE.md — dproperty Performance & UX Upgrade

## Project overview

dproperty is a Laravel + Blade website for buying, selling and renting property in Bangladesh. It is live in production. This repo is a **local clone running on production data** (Windows / XAMPP, PHP 8.2, `php artisan serve` at http://127.0.0.1:8000).

**Goal:** make the site load very fast and feel modern **without changing the visual design**.

Before starting, read `composer.json` and `package.json` to confirm the Laravel version, which packages are installed, and whether Vite is already set up. Adjust the commands below to match.

---

## HARD RULES (never break these)

1. **Do not change the visual design.** Layout, colours, fonts, spacing, card structure, copy and breakpoints must look pixel-identical before and after. You may change how things *load*. You may not change how they *look*.
2. **Keep Blade.** Do not migrate to React, Vue, Inertia or Next.js. Use Livewire only where these instructions say so.
3. **Never modify or delete original uploaded images** in `public/uploads/**` or `storage/app/public/**`. Generated files go in `thumbs/` subfolders only.
4. **No database schema changes to existing columns.** Adding indexes is allowed. Ask before adding any new table or column.
5. **Every image change needs a fallback.** If a thumbnail is missing, serve the original so nothing breaks in production.
6. Respect `prefers-reduced-motion` for every animation.
7. Work **one phase at a time**. At the end of each phase, stop, summarise what changed, and list the files touched before moving on.
8. Do not commit `.env` and do not change production credentials.

---

## Baseline (measured on the homepage, before any changes)

| Metric | Before | Target |
|---|---|---|
| Total page weight | 31.8 MB (images 31.4 MB) | < 1.5 MB |
| Requests | 250 (227 images) | < 45 |
| `<img>` tags in DOM | 688 (272 unique) | < 120 |
| HTML size | 500 KB, uncompressed | < 120 KB, gzip/brotli |
| DOM nodes / Swiper instances | 4,265 / 62 | < 1,500 / initialised on view |
| Server time | 678 ms | < 150 ms (prod < 100 ms) |
| DB queries | 33 (247 ms), 554 models hydrated | < 15, cached |
| LCP | 1.98 s (hero JPG as CSS background) | < 1.2 s |
| Long tasks | 16, worst 386 ms | none > 100 ms |
| CLS | 0.002 | keep < 0.05 |

### Root causes found

- Every property card has an inner Swiper slider with 8–15 **full-size** images (1448–1920 px, 50–250 KB each) shown at 437×240 / 341×240.
- The featured slider (`.custom-card-slider`) has **no `loading="lazy"`**, so all 223 of its images download straight away.
- Swiper `loop: true` duplicates slides, which multiplies the `<img>` tags.
- Laravel Debugbar is enabled (≈213 KB JS + 113 KB CSS on every page).
- Hero image `storage/slider/*.jpg` (232 KB) is a CSS `background-image` and is the LCP element.
- Logo is a 2240×745 PNG (44 KB) shown at 120×40, and it is rendered twice.
- 13 render-blocking stylesheets and 7 synchronous scripts. Both Bootstrap Icons **and** Font Awesome are loaded.
- `cdn.jsdelivr.net/gh/freeps2/a7rarpress@main/*` is loaded from an **unpinned third-party GitHub repo**, partly over `http://`. This is a security risk.
- 574 inline `style=""` attributes; one 28 KB inline script embeds category JSON.
- `locations` and `property_details` are queried 3× each; every query uses `select *`; 425 `PropertyDetailValue` models are hydrated.
- Sessions use the `database` driver (a read and a write on every request).
- No gzip/brotli and no `Cache-Control`/`ETag` on static assets.

---

## PHASE 1 — Quick wins (no visual change)

- [ ] Disable Debugbar outside local: `APP_DEBUG=false`, `DEBUGBAR_ENABLED=false` in production `.env`. Make sure it is in `require-dev` only.
- [ ] Add `defer` to all non-critical `<script>` tags in the main layout. Check that inline scripts that depend on jQuery still run (wrap them in `DOMContentLoaded` or move them into a deferred file).
- [ ] Download the `freeps2/a7rarpress` swiper CSS/JS and `script.js` into `resources/` (or `public/vendor/`), pin them, and serve them locally over HTTPS. Use the official `swiper` npm package if it renders identically.
- [ ] Replace the duplicate logo `<img>` with a 240 px-wide WebP (generated in Phase 2) and set explicit `width`/`height`.
- [ ] Add `<link rel="preconnect">` only for origins still used after Phase 3.

**Acceptance:** before/after screenshots of the homepage (desktop 1440 px + mobile 390 px) look identical. No console errors.

---

## PHASE 2 — Image thumbnails (biggest win)

Existing images are **already uploaded and referenced in the database**. Do **not** re-upload them and do not change DB paths. Generate derived files next to the originals.

### 2.1 Install

```bash
composer require intervention/image-laravel
```

Use the GD driver unless Imagick is available.

### 2.2 `app/Services/ThumbnailService.php`

- `public const SIZES = [480 => 70, 960 => 72];` (width => WebP quality)
- `make(string $absPath, bool $force = false): void` reads the original, calls `scaleDown(width: $w)`, and saves to `{dir}/thumbs/{w}/{filename}.webp`. Skip if the file exists unless `$force`.
- Hero/slider images also need `1280` and `1920` sizes. Make the sizes configurable per call or via `config/thumbnails.php`.

### 2.3 Backfill command `app/Console/Commands/GenerateThumbs.php`

- Signature: `images:thumbs {dir=uploads/property} {--force}`
- Scans the folder directly (not the DB) for jpg/jpeg/png/webp, shows a progress bar, catches and logs per-file errors, and sets `memory_limit` to 512M.
- Run it for: `uploads/property`, `storage/slider`, `storage/logos`, `storage/testimonials`, `storage/contact_image`.

### 2.4 Helper `thumb(?string $path, int $w = 480): string`

- Register it in `app/helpers.php` and autoload it via `composer.json` → `autoload.files`.
- Builds `{dirname}/thumbs/{w}/{filename}.webp`. Returns `asset()` of the thumb if it exists, otherwise `asset()` of the original. Returns a placeholder if `$path` is null.
- Optionally add a model accessor on the property image model that wraps this helper.

### 2.5 New uploads

In every controller/action that stores a property, slider, logo or testimonial image, call `ThumbnailService::make()` right after the file is saved.

### 2.6 Blade changes (markup only, same classes and structure)

Card images:

```blade
<img src="{{ thumb($path) }}"
     srcset="{{ thumb($path, 480) }} 480w, {{ thumb($path, 960) }} 960w"
     sizes="(max-width:768px) 100vw, 437px"
     width="437" height="240" loading="lazy" decoding="async" alt="{{ $alt }}">
```

- Use full-size originals only on the property detail page gallery and in Fancybox (`data-src` = original).

**Acceptance:** homepage image bytes < 1.5 MB; images look sharp on 2× screens; no broken images when a thumb is deleted (fallback works).

---

## PHASE 3 — Card sliders and DOM size

- [ ] In each card's inner slider, render **only the first image** as a real `<img>`. For the remaining slides, put the URL in `data-src` and swap it to `src` on Swiper `slideChange` or on the card's first `pointerenter`/`touchstart`. Keep the slide count and markup the same so the design does not change.
- [ ] Replace `loop: true` with `rewind: true` on card and section sliders, so Swiper does not create duplicate slides. Check that autoplay still behaves the same visually.
- [ ] Initialise Swiper instances only when their section enters the viewport (IntersectionObserver, `rootMargin: '200px'`). Do not create 62 instances on load.
- [ ] Limit each homepage section to the number of cards visible plus one swipe (e.g. 8). Ask the user before changing the count if it alters what is visible.
- [ ] Move repeated inline `style=""` attributes into CSS classes **with identical computed styles**.
- [ ] Move the 28 KB inline category JSON into an endpoint or a deferred JSON `<script type="application/json">` that is read only when the search UI is opened.

**Acceptance:** DOM nodes < 1,500; `<img>` tags < 120; no long task > 100 ms on load; visuals identical.

---

## PHASE 4 — Hero / LCP

- [ ] Change the hero slider background images to an absolutely positioned `<img>` (`object-fit: cover`) inside the same container, so it looks identical.
- [ ] First slide: `fetchpriority="high"`, **no** lazy loading, plus `srcset` 1280w/1920w WebP. Other slides: `loading="lazy"`.
- [ ] Add `<link rel="preload" as="image" imagesrcset="..." imagesizes="100vw">` for the first hero image.

**Acceptance:** LCP < 1.2 s on throttled "Fast 4G".

---

## PHASE 5 — CSS / JS bundling with Vite

- [ ] Move all local CSS (`main.css`, `custom_slider.css`, `neighborhoods.css`, `articles.css`, `property_cards.css`, `property_slider.css`) and JS (`custom/custom_js.js` + page scripts) into Vite entry points. Load them with `@vite([...])`.
- [ ] Install Bootstrap 5.3, Swiper, select2 and @fancyapps/ui from npm, pinned to the versions currently used, instead of the CDNs.
- [ ] Find which icon set is actually used. If both are used, keep both for now but load only the icon font files you need (or subset them). **Do not remove icons that appear on the page.**
- [ ] Load select2 and Fancybox only on pages that use them (separate Vite entries or dynamic `import()`).
- [ ] Optional: purge unused Bootstrap CSS with PurgeCSS, safelisting dynamic classes (`swiper-*`, `select2-*`, `fancybox-*`, `show`, `active`, `collapse*`, `modal*`). Verify visually.

**Acceptance:** ≤ 2 render-blocking CSS files; JS is deferred or a module; visuals identical.

---

## PHASE 6 — Laravel backend

- [ ] Data shared across views (`app_settings`, `locations`, `property_categories`, `services`, `testimonials`, `home_sliders`): load it once in a View Composer / service and wrap it in `Cache::remember(..., 3600)`. Bust the cache in model `saved`/`deleted` events.
- [ ] Remove the triple `locations` and `property_details` queries.
- [ ] Use `select()` with only the columns the cards display. Eager-load only the relations that are needed, with column limits, e.g. `with(['images:id,property_id,image', 'detailValues:id,property_id,property_detail_id,value'])`. Check the real relation and column names first.
- [ ] Add a migration that only adds these indexes:
  - `properties (status, property_status, created_at)`
  - `properties (status, is_home_featured, created_at)`
  - FK columns used in `whereIn` lookups if they are missing.
- [ ] Session driver: switch to `redis` if available, otherwise `file`. Ask before changing it in production.
- [ ] Guest homepage full-page cache: `spatie/laravel-responsecache` with a 10-minute lifetime, skipped for authenticated users. Clear it when properties change.
- [ ] Deployment script / README section: `composer install --no-dev -o`, `php artisan optimize`, `php artisan icons:cache` if relevant, OPcache enabled.

**Acceptance:** homepage ≤ 15 queries on a cold cache and ≤ 3 on a warm one; server time < 150 ms locally.

---

## PHASE 7 — Perceived speed and transitions (no design change)

- [ ] **Speculation Rules** in the layout, so property and listing pages are prerendered on hover:
  ```html
  <script type="speculationrules">
  {"prerender":[{"where":{"href_matches":"/property/*"},"eagerness":"moderate"}]}
  </script>
  ```
  Confirm the real property URL pattern from `routes/web.php` first.
- [ ] **Cross-document View Transitions** (CSS only): `@view-transition { navigation: auto; }` with a short (≤ 250 ms) fade. Use a shared `view-transition-name` on the card image → detail hero image.
- [ ] **Section-by-section loading** of the homepage: server-render the hero plus the first section. Load the sections below it as Blade partials via `fetch('/partials/{section}')` when they come near the viewport, and show a skeleton with the **exact same dimensions** as the final section (no CLS). Partials reuse the existing Blade includes unchanged.
- [ ] **Livewire 3** (only if needed): search/filter results, "Load more", favourites, enquiry form. Use `#[Lazy]` with `placeholder()` skeletons. Do not convert static sections to Livewire.

---

## PHASE 8 — Motion polish (optional, subtle)

- [ ] Add the `motion` npm package (motion.dev, vanilla build, no React). Use `inView` + `animate` for card fade/slide-in (opacity 0→1, y 20→0, 0.4 s) and stat counters.
- [ ] Optional `lenis` smooth scroll on desktop only.
- [ ] All motion is disabled when `prefers-reduced-motion: reduce` is set.
- [ ] **No site-wide WebGL.** At most one hero effect, desktop only (≥ 1024 px), loaded with dynamic `import()` after `window.load`, with a static image fallback.

---

## Server / production (document it; do not apply automatically)

Write `docs/deployment-performance.md` covering:

- Nginx: gzip or brotli for text assets; `expires 1y` + `Cache-Control: public, immutable` for hashed Vite assets and `thumbs/`; HTTP/2 (or HTTP/3).
- Cloudflare in front (edge in Dhaka); cache `/build/*`, `/uploads/*`, `/storage/*`.
- OPcache settings; optional Laravel Octane (FrankenPHP/Swoole) evaluation.

---

## Verification checklist (run after every phase)

1. `php artisan test` (if tests exist) and `npm run build` pass.
2. Visual regression: screenshot homepage, a listing page and a property detail page at 1440 px and 390 px, then compare with the baseline. **Any visual difference = revert or fix.**
3. Chrome DevTools / Lighthouse (mobile, throttled): record weight, requests, LCP, CLS and TBT in a table against the baseline above.
4. Check the console for errors, and that sliders, search (select2), gallery (Fancybox), forms and mobile menu still work.
5. Debugbar (local only): query count and duration.

## Conventions

- Small, reviewable commits, one per checklist item, e.g. `perf(images): add thumbnail service and backfill command`.
- New PHP code: typed properties/returns, a service class for logic, and no logic in Blade beyond the `thumb()` helper.
- Ask before: installing a package not listed here, changing card counts, changing the session/cache driver in production, or touching anything that could change appearance.
