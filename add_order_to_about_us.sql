-- =============================================================
-- Migration: add `order` column to about_us
-- File: 2026_05_22_160000_add_order_to_about_us_table.php
-- Run on the LIVE database after taking a backup.
-- MySQL / MariaDB
-- =============================================================

ALTER TABLE `about_us`
    ADD COLUMN `order` INT UNSIGNED NOT NULL DEFAULT 0 AFTER `status`;

ALTER TABLE `about_us`
    ADD INDEX `about_us_order_index` (`order`);

INSERT INTO `migrations` (`migration`, `batch`)
SELECT '2026_05_22_160000_add_order_to_about_us_table', COALESCE(MAX(`batch`), 0) + 1
FROM `migrations`;

-- Rollback:
-- ALTER TABLE `about_us` DROP INDEX `about_us_order_index`;
-- ALTER TABLE `about_us` DROP COLUMN `order`;
-- DELETE FROM `migrations` WHERE `migration` = '2026_05_22_160000_add_order_to_about_us_table';
