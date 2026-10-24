# Deploying the `performance` branch on cPanel (terminal access)

A runbook to follow top to bottom. Commands run in the cPanel **Terminal** (or SSH)
unless a step says *cPanel UI*. Background on each setting is in
`deployment-performance.md`.

Plan for about 45 minutes, plus about 1 minute of maintenance mode.

---

## 0. Before you start (on your PC)

1. Commit and push the `performance` branch (this repo has no git author configured yet):
   ```bash
   git config user.name "Your Name" && git config user.email "you@example.com"
   git add -A && git commit -m "perf: thumbnails, lazy sliders, Vite bundles, caching"
   git push -u origin performance
   ```
2. Build the front-end assets. `public/build/` is git-ignored, and building on your PC
   avoids needing Node on the server:
   ```bash
   npm ci && npm run build
   # then zip the public/build folder → build.zip
   ```
   You'll upload `build.zip` in step 4.

---

## 1. Find your way around the server (read-only)

```bash
# Where the project lives and what the domain serves
ls ~ ; ls ~/public_html | head
readlink -f ~/public_html            # symlink to the project's public/? note the path
cd <PROJECT_DIR> && git status && git branch   # the folder that contains artisan

# The terminal's `php` is often a different version from the website's. Find PHP 8.2+:
php -v
ls /opt/cpanel/ea-php8*/root/usr/bin/php /opt/alt/php8*/usr/bin/php 2>/dev/null
```

Pick the PHP binary that matches the version the site uses (cPanel → **MultiPHP Manager**
or **Select PHP Version**) and use it for every command below:

```bash
export PHP=/opt/cpanel/ea-php82/root/usr/bin/php     # ← your path
$PHP -v
$PHP -r 'var_dump(gd_info()["WebP Support"] ?? false);'   # must print bool(true)
$PHP -m | grep -i -E "opcache|gd|fileinfo|mbstring|pdo_mysql"
which composer || ls ~/composer.phar
```

Without composer, install it locally (no root needed):
`curl -sS https://getcomposer.org/installer | $PHP -- --install-dir=$HOME --filename=composer.phar`,
then use `$PHP ~/composer.phar` wherever this guide says `composer`.

---

## 2. One-time PHP settings (cPanel UI)

**Select PHP Version** (CloudLinux) or **MultiPHP INI Editor** (EasyApache), for the
PHP version the site uses:

| Setting | Value |
|---|---|
| Extensions | `gd`, `opcache`, `fileinfo`, `mbstring`, `pdo_mysql` enabled |
| `opcache.enable` | 1 |
| `opcache.memory_consumption` | 192 |
| `opcache.max_accelerated_files` | 20000 |
| `opcache.validate_timestamps` | **1** (you can't restart PHP-FPM on shared hosting) |
| `memory_limit` | 256M or more (the thumbnail command asks for 512M; the host may cap it) |

Re-check GD/WebP (step 1) afterwards. **Image uploads in admin also need GD.**

---

## 3. Back up (2 minutes)

```bash
cd <PROJECT_DIR>
mkdir -p ~/backups
cp .env ~/backups/env.$(date +%F)
git rev-parse HEAD > ~/backups/commit.$(date +%F)       # the commit to roll back to
tar czf ~/backups/code.$(date +%F).tgz --exclude=vendor --exclude=node_modules \
    --exclude=public/uploads --exclude=storage/app/public .
```

Also take a database backup in cPanel → **Backup** or **phpMyAdmin → Export**.
Uploaded images aren't modified by this release, so there's no need to back them up again.

---

## 4. Deploy

```bash
cd <PROJECT_DIR>
$PHP artisan down --retry=60          # maintenance page starts

git fetch origin && git checkout performance && git pull origin performance

composer install --no-dev --optimize-autoloader      # also removes Debugbar
```

Upload `build.zip` with cPanel **File Manager** into `<PROJECT_DIR>/public/`, then:

```bash
cd <PROJECT_DIR>/public && rm -rf build && unzip -q ~/path/to/build.zip && cd ..
ls public/build/manifest.json        # must exist, or pages fail with "Vite manifest not found"
```

### 4a. `.env` changes

Edit `.env` with `nano .env` or File Manager:

```dotenv
APP_ENV=production
APP_DEBUG=false
SESSION_DRIVER=file      # was database. Logs everyone out once. Skip this line to keep database.
CACHE_STORE=file         # was database
RESPONSE_CACHE_LIFETIME=600

# Logs: one file per day, kept 14 days, warnings and errors only
# (the old single debug-level file grows forever).
LOG_STACK=daily
LOG_DAILY_DAYS=14
LOG_LEVEL=warning
```

**Sessions and bots.** With `SESSION_DRIVER=file`, every visitor without a cookie (every
bot request) creates one small file, kept for 2 hours. The number of files is roughly
requests per second × 7,200. Shared hosting usually caps the number of files (inodes)
at 250k–500k. Check it now and then:

```bash
ls <PROJECT_DIR>/storage/framework/sessions | wc -l
```

Up to about 100,000 is fine. If it stays above that, switch back to
`SESSION_DRIVER=database`. That costs 2–3 queries per request but no files, and logs
everyone out once.

### 4a-2. Cron job (cPanel → Cron Jobs)

The page cache (10 min) uses files, and the file cache doesn't delete expired entries on
its own. One cached copy per page URL (about 200–450 KB each) stays until the next admin
save clears everything. Add a daily cleanup:

```
15 4 * * *  cd <PROJECT_DIR> && /opt/cpanel/ea-php82/root/usr/bin/php artisan responsecache:clear >/dev/null 2>&1
```

Use your PHP path from step 1.

### 4b. Database (indexes only)

```bash
$PHP artisan migrate:status | grep -E "homepage_indexes|about_us"
```

`add_homepage_indexes_to_properties_table` should already show **Ran**: it was applied
to this database from the development machine on 2026-10-24. If it shows Pending:

```bash
$PHP artisan migrate --path=database/migrations/2026_10_24_000000_add_homepage_indexes_to_properties_table.php --force
```

Do **not** run a plain `php artisan migrate`. `create_about_us_table` is pending even
though that table already exists.

### 4c. Storage link and thumbnails

```bash
ls -la public/storage || $PHP artisan storage:link

# Thumbnails for existing images (originals untouched; safe to re-run).
# Run in the background so a dropped terminal doesn't kill it:
nohup sh -c '
  P='"$PHP"'
  $P artisan images:thumbs uploads/property
  $P artisan images:thumbs uploads/locations
  $P artisan images:thumbs uploads/articles
  $P artisan images:thumbs storage/testimonials
  $P artisan images:thumbs storage/contact_image
  $P artisan images:thumbs storage/slider --sizes=1280:75,1920:75
  $P artisan images:thumbs storage/logos --sizes=240:80
' > storage/logs/thumbs.log 2>&1 &

tail -f storage/logs/thumbs.log      # Ctrl+C to stop watching; it keeps running
```

The site works before this finishes: any missing thumbnail falls back to the original.
Failures are logged in `storage/logs/laravel.log` (`images:thumbs failed for …`).

### 4d. Caches and go live

```bash
$PHP artisan optimize:clear
$PHP artisan optimize               # config, routes, events, views
$PHP artisan responsecache:clear
$PHP artisan up
```

---

## 5. Compression and browser caching (`public/.htaccess`)

cPanel serves through Apache or LiteSpeed, so this goes in `.htaccess` (not Nginx).
Add it **below** the existing `</IfModule>` in `<PROJECT_DIR>/public/.htaccess`:

```apache
# --- performance: compression ---
<IfModule mod_deflate.c>
    AddOutputFilterByType DEFLATE text/html text/css text/plain application/javascript application/json image/svg+xml
</IfModule>

# --- performance: browser caching ---
<IfModule mod_expires.c>
    ExpiresActive On
    ExpiresByType image/webp "access plus 30 days"
    ExpiresByType image/jpeg "access plus 30 days"
    ExpiresByType image/png  "access plus 30 days"
    ExpiresByType font/woff2 "access plus 1 year"
</IfModule>
<IfModule mod_headers.c>
    # Vite file names change on every build, so they can be cached forever
    <If "%{REQUEST_URI} =~ m#^/build/#">
        Header set Cache-Control "public, max-age=31536000, immutable"
    </If>
</IfModule>
```

If you'd rather keep this in git, ask and it can be committed to the repo instead.

Check it:
```bash
curl -sI -H "Accept-Encoding: gzip" https://dproperty.com.bd/ | grep -i -E "content-encoding|cache-control"
curl -sI https://dproperty.com.bd/build/manifest.json | grep -i cache-control
```

If Cloudflare is in front, turn on Brotli there and add a cache rule for `/build/*`,
`/uploads/*` and `/storage/*`. Don't cache HTML at the edge.

### Cloudflare rate limit for search pages (protects the server's capacity)

Plain listing and property URLs are served from the page cache. Filtered searches
(`/rent?location=…&bedrooms=…`) and later pages (`?page=2`) always run database
queries, and a crawler can request endless combinations. In Cloudflare →
**Security → WAF → Rate limiting rules → Create rule**:

| Field | Value |
|---|---|
| If incoming requests match | `(http.request.uri.path in {"/rent" "/buy" "/sell"} or starts_with(http.request.uri.path, "/location/")) and http.request.uri.query ne ""` |
| With the same characteristics | IP |
| When rate exceeds | 30 requests per 10 seconds |
| Then | Managed Challenge (or Block) for 1 minute |

If your Cloudflare plan doesn't offer the query field in rate limiting rules, drop the
`and http.request.uri.query ne ""` part and raise the limit to 60 per 10 seconds.
A real visitor clicking through filters stays far below that. Also consider
**Security → Bots → Bot Fight Mode: On**.

---

## 6. Verify (10 minutes)

```bash
for u in / /rent /buy /sell /property-details/5 /blog /about-us /contact-us; do
  printf "%-22s " "$u"; curl -s -o /dev/null -w "%{http_code} %{time_starttransfer}s\n" "https://dproperty.com.bd$u"
done
# All 200. Run it twice: the second "/" should be well under 0.1s (page cache).

curl -s https://dproperty.com.bd/ | grep -c "thumbs/480"       # > 0 once thumbnails exist
tail -n 50 storage/logs/laravel.log                              # no new errors
```

In a browser (desktop and phone), with DevTools Console open:

- Homepage: hero, featured/rent/sell sliders autoplay; hovering a card then using its arrows shows the next photos.
- Search: location/type dropdowns (select2) open and searching works; "View All Image" opens the gallery.
- Listing and property pages: filters, gallery, thumbnails strip, phone reveal button.
- Mobile menu opens and closes.
- **Admin:** log in, edit a property and save it. The homepage should show the change at once (the cache is cleared on save). Upload a new image and check that a `thumbs/480/…webp` file appears next to it.
- Console: no red errors.

---

## 7. Rollback

```bash
cd <PROJECT_DIR>
$PHP artisan down
git checkout <commit from ~/backups/commit.DATE>
cp ~/backups/env.DATE .env
composer install --no-dev --optimize-autoloader
$PHP artisan optimize:clear
$PHP artisan up
```

You can leave the old site's `public/build`, the thumbnails and the two DB indexes in
place. The old code ignores them. To drop the indexes anyway:
`$PHP artisan migrate:rollback --path=database/migrations/2026_10_24_000000_add_homepage_indexes_to_properties_table.php --force`.

---

## 8. Every later deploy (short version)

```bash
# PC:     npm run build → zip public/build → upload
# Server:
cd <PROJECT_DIR> && $PHP artisan down --retry=60
git pull origin performance
composer install --no-dev --optimize-autoloader      # only if composer.lock changed
# unzip the new public/build
$PHP artisan optimize && $PHP artisan responsecache:clear && $PHP artisan up
```

New uploaded images get thumbnails automatically. Re-run `images:thumbs` only if
images were copied in by hand (FTP or File Manager).
