# Deploying the performance upgrade

What the server needs for the `performance` branch to run fast in production.
Nothing here is applied automatically.

## 1. One-time server requirements

| Requirement | Why |
|---|---|
| PHP `gd` extension with WebP support | Thumbnails (`images:thumbs`, and every admin image upload). Check: `php -r 'var_dump(gd_info()["WebP Support"] ?? false);'` |
| OPcache enabled for PHP-FPM | Laravel boot drops from ~150 ms to a few ms per request. |
| Node 20+ on the build machine | `npm run build` produces `public/build/` (git-ignored). |
| Writable `storage/` and `public/uploads/**/thumbs/`, `storage/app/public/**/thumbs/` | Page cache, data cache, generated thumbnails. |

## 2. `.env` (production)

```dotenv
APP_DEBUG=false
DEBUGBAR_ENABLED=false            # Debugbar is also forced off outside APP_ENV=local
SESSION_DRIVER=file               # was database: 2–3 queries per request. Use redis if the phpredis extension is installed.
CACHE_STORE=file                  # was database. Same note about redis.
RESPONSE_CACHE_LIFETIME=600       # guest homepage cache, seconds (default 600)
```

Changing `SESSION_DRIVER` logs everyone out once (admins included). Changing
`CACHE_STORE` is safe at any time.

## 3. Deploy steps

```bash
composer install --no-dev --optimize-autoloader
npm ci && npm run build

# Index-only migration (no column changes). Run it by path: there is an older
# pending migration (create_about_us_table) whose table already exists.
php artisan migrate --path=database/migrations/2026_10_24_000000_add_homepage_indexes_to_properties_table.php --force

# Thumbnails for images uploaded before this release (originals are never touched;
# new uploads get thumbnails automatically). Safe to re-run; add --force to rebuild.
php artisan images:thumbs uploads/property
php artisan images:thumbs uploads/locations
php artisan images:thumbs uploads/articles
php artisan images:thumbs storage/testimonials
php artisan images:thumbs storage/contact_image
php artisan images:thumbs storage/slider --sizes=1280:75,1920:75
php artisan images:thumbs storage/logos --sizes=240:80

php artisan optimize               # config, route, event, view caches
php artisan responsecache:clear
```

If a thumbnail is missing for any reason, pages fall back to the original image.

## 4. Caches and when they clear

- **Guest homepage** (full HTML, 10 min, `spatie/laravel-responsecache`). Never used for
  signed-in users.
- **Site data** (settings, locations, categories, sliders, testimonials, tags, 1 h).

Both are cleared automatically whenever an admin saves or deletes a property, property
detail, location, category, slider, testimonial, tag, article or the app settings.
Changes made directly in the database (phpMyAdmin, SQL scripts) are not detected: run
`php artisan cache:clear && php artisan responsecache:clear` afterwards.

## 5. Nginx

```nginx
http2 on;                                   # or listen 443 quic for HTTP/3

gzip on;
gzip_comp_level 5;
gzip_types text/css application/javascript application/json image/svg+xml text/plain;
# brotli on; brotli_types ...;              # if ngx_brotli is installed

# Hashed Vite assets never change for a given URL
location /build/ {
    expires 1y;
    add_header Cache-Control "public, immutable";
    access_log off;
}

# Generated thumbnails (file names follow the original; regenerated with --force)
location ~* /thumbs/ {
    expires 30d;
    add_header Cache-Control "public";
    access_log off;
}

location ~* \.(?:jpe?g|png|webp|svg|woff2?)$ {
    expires 30d;
    add_header Cache-Control "public";
}
```

Thumbnails get 30 days rather than `immutable`, because `images:thumbs --force`
rewrites them under the same URL.

## 6. Cloudflare (optional, recommended)

- Proxy the domain through Cloudflare; the nearest edge to Bangladesh visitors is Dhaka.
- Cache rule: cache everything for `/build/*`, `/uploads/*`, `/storage/*`, and respect origin headers.
- Do **not** cache HTML at the edge. The homepage is already cached on the server, and
  admin pages must never be shared.

## 7. PHP / OPcache

```ini
opcache.enable=1
opcache.memory_consumption=192
opcache.interned_strings_buffer=16
opcache.max_accelerated_files=20000
opcache.validate_timestamps=0   ; set to 1 if you deploy without restarting PHP-FPM
```

With `validate_timestamps=0`, restart PHP-FPM after every deploy.

Measured locally with OPcache + `php artisan optimize`: cached homepage TTFB 8–16 ms,
uncached pages 110–160 ms (most of that is round trips to the remote MySQL server).

**Laravel Octane** (FrankenPHP or Swoole) would remove the remaining per-request boot
cost. It's not needed for the current targets. Evaluate it only if uncached pages need
to get faster. It requires checking that no code keeps per-request state in static
properties.
