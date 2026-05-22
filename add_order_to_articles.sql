-- =============================================================
-- Migration: add `order` column to articles
-- File: 2026_05_22_130000_add_order_to_articles_table.php
-- Run on the LIVE database after taking a backup.
-- MySQL / MariaDB
-- =============================================================

-- 1) Add the column. Default 0 so existing rows are valid.
ALTER TABLE `articles`
    ADD COLUMN `order` INT UNSIGNED NOT NULL DEFAULT 0 AFTER `status`;

-- 2) Index for faster ORDER BY `order`.
ALTER TABLE `articles`
    ADD INDEX `articles_order_index` (`order`);

-- 3) Register the migration as already run so `php artisan migrate`
--    on production does NOT try to apply it again.
INSERT INTO `migrations` (`migration`, `batch`)
SELECT '2026_05_22_130000_add_order_to_articles_table', COALESCE(MAX(`batch`), 0) + 1
FROM `migrations`;

-- =============================================================
-- Rollback (only if you need to revert):
-- ALTER TABLE `articles` DROP INDEX `articles_order_index`;
-- ALTER TABLE `articles` DROP COLUMN `order`;
-- DELETE FROM `migrations` WHERE `migration` = '2026_05_22_130000_add_order_to_articles_table';
-- =============================================================
